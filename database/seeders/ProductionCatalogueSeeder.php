<?php

namespace Database\Seeders;

use App\Models\ProductListing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
use Lunar\Models\ProductVariant;
use Lunar\Models\TaxClass;

class ProductionCatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $created = DB::transaction(function (): int {
            Channel::firstOrCreate(['handle' => 'webstore'], [
                'name' => 'Wiener Box',
                'default' => ! Channel::where('default', true)->exists(),
                'url' => config('app.url'),
            ]);
            Language::firstOrCreate(['code' => 'en'], [
                'name' => 'English',
                'default' => ! Language::where('default', true)->exists(),
            ]);
            $currency = Currency::firstOrCreate(['code' => 'AUD'], [
                'name' => 'Australian Dollar',
                'exchange_rate' => 1,
                'decimal_places' => 2,
                'default' => ! Currency::where('default', true)->exists(),
                'enabled' => true,
            ]);
            CustomerGroup::firstOrCreate(['handle' => 'retail'], [
                'name' => 'Retail',
                'default' => ! CustomerGroup::where('default', true)->exists(),
            ]);
            CollectionGroup::firstOrCreate(['handle' => 'main'], ['name' => 'Main']);
            $taxClass = TaxClass::where('default', true)->first()
                ?? TaxClass::first()
                ?? TaxClass::create(['name' => 'Default', 'default' => true]);

            foreach ([Product::morphName(), Collection::morphName()] as $morph) {
                $group = AttributeGroup::firstOrCreate(['handle' => $morph.'_details'], [
                    'attributable_type' => $morph,
                    'name' => collect(['en' => 'Details']),
                    'position' => 1,
                ]);

                foreach (['name' => 'Name', 'description' => 'Description'] as $handle => $label) {
                    Attribute::firstOrCreate(['attribute_type' => $morph, 'handle' => $handle], [
                        'attribute_group_id' => $group->id,
                        'position' => $handle === 'name' ? 1 : 2,
                        'name' => ['en' => $label],
                        'section' => 'main',
                        'type' => TranslatedText::class,
                        'required' => $handle === 'name',
                        'system' => $handle === 'name',
                        'configuration' => ['richtext' => false],
                        'description' => ['en' => ''],
                    ]);
                }
            }

            $productType = ProductType::firstOrCreate(['name' => 'Sausages and boxes']);
            $productType->mappedAttributes()->syncWithoutDetaching(
                Attribute::where('attribute_type', Product::morphName())->pluck('id')
            );

            $created = 0;

            foreach (config('catalogue.products') as $position => $item) {
                $sku = 'WB-'.strtoupper($item['slug']);

                if (ProductListing::where('slug', $item['slug'])->exists()
                    || ProductVariant::withTrashed()->whereIn('sku', [$sku, 'PREVIEW-'.strtoupper($item['slug'])])->exists()) {
                    continue;
                }

                $product = Product::create([
                    'product_type_id' => $productType->id,
                    'status' => 'published',
                    'attribute_data' => [
                        'name' => new TranslatedText(['en' => $item['name']]),
                        'description' => new TranslatedText(['en' => $item['story']]),
                    ],
                ]);
                $variant = $product->variants()->create([
                    'tax_class_id' => $taxClass->id,
                    'sku' => $sku,
                    'stock' => 0,
                    'purchasable' => 'in_stock',
                    'unit_quantity' => 1,
                    'shippable' => true,
                ]);
                $variant->prices()->create([
                    'currency_id' => $currency->id,
                    'price' => $item['price'],
                    'min_quantity' => 1,
                ]);
                ProductListing::create(Arr::except($item, ['name', 'price']) + [
                    'product_id' => $product->id,
                    'published' => true,
                    'position' => $position,
                ]);

                $created++;
            }

            return $created;
        });

        $this->command?->info("Created {$created} catalogue offers; existing offers were preserved.");
    }
}
