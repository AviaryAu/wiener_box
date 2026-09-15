<?php

namespace Database\Seeders;

use App\Models\DeliveryArea;
use App\Models\ProductListing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Attribute;
use Lunar\Models\AttributeGroup;
use Lunar\Models\Channel;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;
use Lunar\Models\Language;
use Lunar\Models\Product;
use Lunar\Models\ProductType;
use Lunar\Models\TaxClass;
use Lunar\Models\TaxZone;

class PreviewCatalogueSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new \RuntimeException('Preview catalogue seeding is restricted to local and testing environments.');
        }
        Channel::firstOrCreate(['handle' => 'webstore'], ['name' => 'Wiener Box', 'default' => true, 'url' => config('app.url')]);
        Language::firstOrCreate(['code' => 'en'], ['name' => 'English', 'default' => true]);
        $currency = Currency::firstOrCreate(['code' => 'AUD'], ['name' => 'Australian Dollar', 'exchange_rate' => 1, 'decimal_places' => 2, 'default' => true, 'enabled' => true]);
        CustomerGroup::firstOrCreate(['handle' => 'retail'], ['name' => 'Retail', 'default' => true]);
        CollectionGroup::firstOrCreate(['handle' => 'main'], ['name' => 'Main']);
        $tax = TaxClass::firstOrCreate(['default' => true], ['name' => 'Preview — tax classification pending']);
        TaxZone::firstOrCreate(['default' => true], ['name' => 'Preview Australia', 'zone_type' => 'country', 'price_display' => 'tax_inclusive', 'active' => true]);
        foreach ([Product::morphName(), Collection::morphName()] as $morph) {
            $group = AttributeGroup::firstOrCreate(['handle' => $morph.'_details'], ['attributable_type' => $morph, 'name' => collect(['en' => 'Details']), 'position' => 1]);
            foreach (['name' => 'Name', 'description' => 'Description'] as $handle => $label) {
                Attribute::firstOrCreate(['attribute_type' => $morph, 'handle' => $handle], [
                    'attribute_group_id' => $group->id, 'position' => $handle === 'name' ? 1 : 2,
                    'name' => ['en' => $label], 'section' => 'main', 'type' => TranslatedText::class,
                    'required' => $handle === 'name', 'system' => $handle === 'name',
                    'configuration' => ['richtext' => false], 'description' => ['en' => ''],
                ]);
            }
        }
        $type = ProductType::firstOrCreate(['name' => 'Sausages and boxes']);
        $type->mappedAttributes()->syncWithoutDetaching(Attribute::where('attribute_type', Product::morphName())->pluck('id'));
        foreach (config('catalogue.products') as $position => $item) {
            if (ProductListing::where('slug', $item['slug'])->exists()) {
                continue;
            }
            $product = Product::create(['product_type_id' => $type->id, 'status' => 'published', 'attribute_data' => [
                'name' => new TranslatedText(['en' => $item['name']]), 'description' => new TranslatedText(['en' => $item['story']]),
            ]]);
            $variant = $product->variants()->create(['tax_class_id' => $tax->id, 'sku' => 'PREVIEW-'.strtoupper($item['slug']), 'stock' => 0, 'purchasable' => 'always', 'unit_quantity' => 1, 'shippable' => true]);
            $variant->prices()->create(['currency_id' => $currency->id, 'price' => $item['price'], 'min_quantity' => 1]);
            ProductListing::create(Arr::except($item, ['name', 'price']) + ['product_id' => $product->id, 'published' => true, 'position' => $position]);
        }
        foreach (['2000' => 'Sydney', '2010' => 'Surry Hills', '2042' => 'Newtown', '2060' => 'North Sydney', '2026' => 'Bondi'] as $postcode => $suburb) {
            DeliveryArea::firstOrCreate(['postcode' => (string) $postcode], ['suburb' => $suburb, 'status' => 'planned', 'price' => 1200]);
        }
    }
}
