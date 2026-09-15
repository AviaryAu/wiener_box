<?php

namespace Database\Seeders;

use App\Models\ProductListing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Lunar\FieldTypes\TranslatedText;
use RuntimeException;

class PreviewBoxBrandingSeeder extends Seeder
{
    public const array BOXES = [
        'the-regular' => [
            'name' => 'The Big Wiener Club',
            'tagline' => 'Membership has its perks. Mostly sausages.',
        ],
        'the-fling' => [
            'name' => 'The Wurst Fling',
            'tagline' => 'Big flavour. No strings attached.',
        ],
        'the-big-gesture' => [
            'name' => 'Nice Package',
            'tagline' => 'Say it with sausages.',
        ],
    ];

    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('Preview box branding updates are restricted to local and testing environments.');
        }

        DB::transaction(function (): void {
            foreach (self::BOXES as $slug => $branding) {
                $listing = ProductListing::where('slug', $slug)->firstOrFail();
                $product = $listing->product;
                $attributes = $product->attribute_data;
                $names = $attributes->get('name')->getValue();
                $attributes->put('name', new TranslatedText($names->put('en', $branding['name'])));

                $product->update(['attribute_data' => $attributes]);
                $listing->update(['eyebrow' => $branding['tagline']]);
            }
        });
    }
}
