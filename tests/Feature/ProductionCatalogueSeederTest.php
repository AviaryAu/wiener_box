<?php

namespace Tests\Feature;

use App\Models\ProductListing;
use Database\Seeders\PreviewCatalogueSeeder;
use Database\Seeders\ProductionCatalogueSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Channel;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;
use Lunar\Models\Language;
use Lunar\Models\ProductVariant;
use Lunar\Models\TaxClass;
use RuntimeException;
use Tests\TestCase;

class ProductionCatalogueSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance('env', 'production');
        $this->withoutVite();
    }

    public function test_production_command_seeds_six_visible_offers_with_aud_prices(): void
    {
        $this->artisan('db:seed', [
            '--class' => ProductionCatalogueSeeder::class,
            '--force' => true,
            '--no-interaction' => true,
        ])->expectsOutput('Created 6 catalogue offers; existing offers were preserved.')->assertSuccessful();

        $this->assertDatabaseCount('product_listings', 6);
        $this->assertDatabaseCount('lunar_products', 6);
        $this->assertDatabaseCount('lunar_product_variants', 6);
        $this->assertDatabaseCount('lunar_prices', 6);
        $this->assertDatabaseHas('lunar_currencies', ['code' => 'AUD', 'decimal_places' => 2, 'default' => true, 'enabled' => true]);
        $this->assertDatabaseCount('delivery_areas', 0);
        $this->assertDatabaseCount('lunar_tax_zones', 0);
        $this->assertDatabaseCount('lunar_tax_rates', 0);
        $this->assertDatabaseCount('lunar_orders', 0);

        $this->get('/')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Home')->has('products', 3)
            ->where('products.0.name', 'The Big Wiener Club')->where('products.0.price', 5900)
            ->where('products.1.name', 'The Wurst Fling')->where('products.1.price', 6500)
            ->where('products.2.name', 'Nice Package')->where('products.2.price', 7900));
        $this->get('/shop')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Shop')->has('products', 6)
            ->where('products.3.name', 'Classic Wieners')->where('products.3.price', 850)
            ->where('products.4.name', 'Bratwurst')->where('products.4.price', 890)
            ->where('products.5.name', 'Cheese Kransky')->where('products.5.price', 990));
        $this->assertDatabaseHas('lunar_product_variants', [
            'sku' => 'WB-THE-REGULAR', 'stock' => 0, 'purchasable' => 'in_stock',
        ]);
    }

    public function test_rerunning_preserves_admin_edits_and_does_not_duplicate_records(): void
    {
        $this->seedProductionCatalogue();
        $listing = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $listing->update(['story' => 'Owner-written story', 'published' => false, 'position' => 9]);
        $product = $listing->product;
        $attributes = $product->attribute_data;
        $attributes->put('name', new TranslatedText(['en' => 'Owner-named box']));
        $product->update(['attribute_data' => $attributes, 'status' => 'draft']);
        $variant = $product->variants->first();
        $variant->update(['stock' => 42, 'sku' => 'OWNER-BOX']);
        $price = $variant->prices->first();
        $price->update(['price' => 6100]);
        $listingIds = ProductListing::orderBy('id')->pluck('id')->all();

        $this->seedProductionCatalogue();

        $this->assertSame($listingIds, ProductListing::orderBy('id')->pluck('id')->all());
        $this->assertDatabaseCount('lunar_products', 6);
        $this->assertDatabaseCount('lunar_product_variants', 6);
        $this->assertDatabaseCount('lunar_prices', 6);
        $this->assertDatabaseHas('product_listings', [
            'id' => $listing->id, 'story' => 'Owner-written story', 'published' => false, 'position' => 9,
        ]);
        $this->assertSame('Owner-named box', $product->fresh()->translateAttribute('name'));
        $this->assertDatabaseHas('lunar_products', ['id' => $product->id, 'status' => 'draft']);
        $this->assertDatabaseHas('lunar_product_variants', ['id' => $variant->id, 'stock' => 42, 'sku' => 'OWNER-BOX']);
        $this->assertSame(6100, $price->fresh()->price->value);
    }

    public function test_rerunning_does_not_recreate_renamed_or_deleted_offers(): void
    {
        $this->seedProductionCatalogue();
        $renamed = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $renamed->update(['slug' => 'monthly-club']);
        $deleted = ProductListing::where('slug', 'the-fling')->firstOrFail();
        $variant = $deleted->product->variants->first();
        $variant->delete();
        $deleted->delete();

        $this->seedProductionCatalogue();

        $this->assertDatabaseCount('product_listings', 5);
        $this->assertDatabaseCount('lunar_products', 6);
        $this->assertDatabaseCount('lunar_product_variants', 6);
        $this->assertDatabaseHas('product_listings', ['id' => $renamed->id, 'slug' => 'monthly-club']);
        $this->assertDatabaseMissing('product_listings', ['slug' => 'the-regular']);
        $this->assertDatabaseMissing('product_listings', ['slug' => 'the-fling']);
        $this->assertSoftDeleted($variant);
    }

    public function test_existing_preview_catalogue_is_preserved_including_renamed_offers(): void
    {
        $this->app->instance('env', 'testing');
        $this->seed(PreviewCatalogueSeeder::class);
        $listing = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $listing->update(['slug' => 'monthly-club']);
        $this->app->instance('env', 'production');

        $this->seedProductionCatalogue();

        $this->assertDatabaseCount('product_listings', 6);
        $this->assertDatabaseCount('lunar_products', 6);
        $this->assertDatabaseCount('lunar_prices', 6);
        $this->assertSame(0, ProductVariant::where('sku', 'like', 'WB-%')->count());
        $this->assertDatabaseMissing('product_listings', ['slug' => 'the-regular']);
        $this->assertDatabaseCount('lunar_tax_classes', 1);
        $this->assertDatabaseCount('lunar_tax_zones', 1);
        $this->assertDatabaseCount('delivery_areas', 5);
    }

    public function test_existing_store_defaults_and_tax_class_are_preserved(): void
    {
        $channel = Channel::factory()->create(['handle' => 'existing-store', 'default' => true]);
        $language = Language::factory()->create(['code' => 'de', 'default' => true]);
        $currency = Currency::factory()->create(['code' => 'USD', 'default' => true]);
        $group = CustomerGroup::factory()->create(['handle' => 'members', 'default' => true]);
        $taxClass = TaxClass::factory()->create(['name' => 'Owner-configured tax class', 'default' => true]);

        $this->seedProductionCatalogue();

        $this->assertDatabaseHas('lunar_channels', ['id' => $channel->id, 'default' => true]);
        $this->assertDatabaseHas('lunar_channels', ['handle' => 'webstore', 'default' => false]);
        $this->assertDatabaseHas('lunar_languages', ['id' => $language->id, 'default' => true]);
        $this->assertDatabaseHas('lunar_languages', ['code' => 'en', 'default' => false]);
        $this->assertDatabaseHas('lunar_currencies', ['id' => $currency->id, 'default' => true]);
        $this->assertDatabaseHas('lunar_currencies', ['code' => 'AUD', 'default' => false]);
        $this->assertDatabaseHas('lunar_customer_groups', ['id' => $group->id, 'default' => true]);
        $this->assertDatabaseHas('lunar_customer_groups', ['handle' => 'retail', 'default' => false]);
        $this->assertDatabaseCount('lunar_tax_classes', 1);
        $this->assertDatabaseHas('lunar_tax_classes', ['id' => $taxClass->id, 'name' => 'Owner-configured tax class']);
        $this->assertSame(6, ProductVariant::where('tax_class_id', $taxClass->id)->count());
    }

    public function test_failure_rolls_back_the_entire_catalogue_and_initial_settings(): void
    {
        config(['catalogue.products.5.category' => null]);

        $this->assertThrows(fn () => app(ProductionCatalogueSeeder::class)->run(), QueryException::class);

        $this->assertDatabaseCount('product_listings', 0);
        $this->assertDatabaseCount('lunar_products', 0);
        $this->assertDatabaseCount('lunar_product_variants', 0);
        $this->assertDatabaseCount('lunar_prices', 0);
        $this->assertDatabaseCount('lunar_currencies', 0);
        $this->assertDatabaseCount('lunar_channels', 0);
        $this->assertDatabaseCount('lunar_tax_classes', 0);
    }

    public function test_default_and_preview_seeders_still_do_not_seed_production(): void
    {
        $this->artisan('db:seed', ['--force' => true, '--no-interaction' => true])->assertSuccessful();
        $this->assertThrows(fn () => app(PreviewCatalogueSeeder::class)->run(), RuntimeException::class);

        $this->assertDatabaseCount('product_listings', 0);
        $this->assertDatabaseCount('lunar_products', 0);
    }

    private function seedProductionCatalogue(): void
    {
        $this->artisan('db:seed', [
            '--class' => ProductionCatalogueSeeder::class,
            '--force' => true,
            '--no-interaction' => true,
        ])->assertSuccessful();
    }
}
