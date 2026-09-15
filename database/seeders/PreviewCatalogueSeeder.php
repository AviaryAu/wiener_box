<?php

namespace Database\Seeders;

use App\Models\DeliveryArea;
use App\Models\ProductListing;
use Illuminate\Database\Seeder;
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
        $items = [
            ['the-regular', PreviewBoxBrandingSeeder::BOXES['the-regular']['name'], PreviewPricingSeeder::PRICES['the-regular'], 'subscription', PreviewBoxBrandingSeeder::BOXES['the-regular']['tagline'], 'mustard', 'monthly', 'Your next BBQ, on repeat. A rotating discovery box for people who take their sausage seriously.', ['Rotating sausage selection', 'A little recipe inspiration', 'Monthly delivery proposed'], ['A curated mix of German-style sausage packs', 'A recipe card with a fresh serving idea'], true],
            ['the-fling', PreviewBoxBrandingSeeder::BOXES['the-fling']['name'], PreviewPricingSeeder::PRICES['the-fling'], 'box', PreviewBoxBrandingSeeder::BOXES['the-fling']['tagline'], 'sage', 'one-off', 'All the good stuff, just this once. Meet your next favourite without making it a monthly thing.', ['One-off discovery box', 'Made for curious appetites', 'No ongoing commitment'], ['A curated mix of German-style sausage packs', 'Ideas for your next cook-up'], true],
            ['the-big-gesture', PreviewBoxBrandingSeeder::BOXES['the-big-gesture']['name'], PreviewPricingSeeder::PRICES['the-big-gesture'], 'gift', PreviewBoxBrandingSeeder::BOXES['the-big-gesture']['tagline'], 'peach', 'one-off', 'Flowers are lovely. Sausages are dinner. A generous gift box for your favourite grill enthusiast.', ['A one-off gift box', 'Gift note planned for launch', 'Ridiculously good gifting'], ['A generous German-style sausage selection', 'A personal gift note at launch'], true],
            ['classic-wieners', 'Classic Wieners', PreviewPricingSeeder::PRICES['classic-wieners'], 'pack', 'THE ORIGINAL CROWD-PLEASER', 'mustard', 'one-off', 'A familiar favourite for hot dogs, quick dinners and one-more-bite moments.', ['Individual pack concept', 'German-style favourite', 'Final size to be confirmed'], ['One sausage pack; size, ingredients and allergens pending supplier confirmation'], false],
            ['bratwurst', 'Bratwurst', PreviewPricingSeeder::PRICES['bratwurst'], 'pack', 'MEET YOUR GRILL FRIEND', 'sage', 'one-off', 'The classic German-style grill companion. Bring the mustard and make an afternoon of it.', ['Individual pack concept', 'A BBQ staple', 'Final size to be confirmed'], ['One sausage pack; size, ingredients and allergens pending supplier confirmation'], false],
            ['cheese-kransky', 'Cheese Kransky', PreviewPricingSeeder::PRICES['cheese-kransky'], 'pack', 'A LITTLE EXTRA CHEESY', 'peach', 'one-off', 'For the cheese-in-everything crowd. A hearty contender for the best thing on the BBQ.', ['Individual pack concept', 'For cheese lovers', 'Final size to be confirmed'], ['One sausage pack; size, ingredients and allergens pending supplier confirmation'], false],
        ];
        foreach ($items as $position => [$slug, $name, $amount, $category, $eyebrow, $colour, $cadence, $story, $highlights, $contents, $featured]) {
            if (ProductListing::where('slug', $slug)->exists()) {
                continue;
            }
            $product = Product::create(['product_type_id' => $type->id, 'status' => 'published', 'attribute_data' => [
                'name' => new TranslatedText(['en' => $name]), 'description' => new TranslatedText(['en' => $story]),
            ]]);
            $variant = $product->variants()->create(['tax_class_id' => $tax->id, 'sku' => 'PREVIEW-'.strtoupper($slug), 'stock' => 0, 'purchasable' => 'always', 'unit_quantity' => 1, 'shippable' => true]);
            $variant->prices()->create(['currency_id' => $currency->id, 'price' => $amount, 'min_quantity' => 1]);
            ProductListing::create(compact('slug', 'category', 'eyebrow', 'colour', 'cadence', 'story', 'highlights', 'contents', 'featured', 'position') + ['product_id' => $product->id, 'published' => true]);
        }
        foreach (['2000' => 'Sydney', '2010' => 'Surry Hills', '2042' => 'Newtown', '2060' => 'North Sydney', '2026' => 'Bondi'] as $postcode => $suburb) {
            DeliveryArea::firstOrCreate(['postcode' => (string) $postcode], ['suburb' => $suburb, 'status' => 'planned', 'price' => 1200]);
        }
    }
}
