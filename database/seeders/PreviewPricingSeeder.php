<?php

namespace Database\Seeders;

use App\Models\ProductListing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Lunar\Models\Currency;
use RuntimeException;

class PreviewPricingSeeder extends Seeder
{
    public const array PRICES = [
        'the-regular' => 5900,
        'the-fling' => 6500,
        'the-big-gesture' => 7900,
        'classic-wieners' => 850,
        'bratwurst' => 890,
        'cheese-kransky' => 990,
    ];

    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('Preview pricing updates are restricted to local and testing environments.');
        }

        DB::transaction(function (): void {
            $currency = Currency::where('code', 'AUD')->firstOrFail();

            foreach (self::PRICES as $slug => $amount) {
                $listing = ProductListing::where('slug', $slug)->firstOrFail();
                $variant = $listing->product->variants()->where('sku', 'PREVIEW-'.strtoupper($slug))->firstOrFail();
                $price = $variant->prices()
                    ->where('currency_id', $currency->id)
                    ->where('min_quantity', 1)
                    ->whereNull('customer_group_id')
                    ->firstOrFail();

                $price->update(['price' => $amount]);
            }
        });
    }
}
