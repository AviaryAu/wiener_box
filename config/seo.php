<?php

return [
    'indexing_enabled' => (bool) env('SEO_INDEXING_ENABLED', false),
    'site_name' => 'Wiener Box',
    'image' => '/images/products/regular-open-box.webp',
    'image_alt' => 'An open Wiener Box with individually sealed sausage packs. Final contents and packaging may differ.',
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),

    'pages' => [
        'home' => [
            'title' => 'German-Style Sausage Boxes in Sydney',
            'description' => 'Meet Wiener Box: German-style sausage subscriptions, one-off boxes and gifts, coming to Sydney. Explore the preview range and join the launch list.',
        ],
        'shop' => [
            'title' => 'Sausage Boxes, Subscriptions & Gifts',
            'description' => 'Explore German-style sausage boxes, monthly subscriptions, gifts, bratwurst, classic wieners and cheese kransky. Preview the Wiener Box range for Sydney.',
        ],
        'delivery' => [
            'title' => 'Sydney Sausage Delivery | Check Your Postcode',
            'description' => 'Check your postcode for Wiener Box’s proposed Sydney chilled sausage delivery area. Join the launch list for updates; coverage and dates are being confirmed.',
        ],
        'how-it-works' => [
            'title' => 'How Our Sausage Boxes & Subscriptions Work',
            'description' => 'Discover the Wiener Box idea: monthly sausage discovery boxes, one-off boxes and gifts, with chilled Sydney delivery planned. Learn about the launch preview.',
        ],
        'recipes' => [
            'title' => 'Recipes, German Sides & Sausage Sauces',
            'description' => 'Make a meal of it with Wiener Box recipes: German-inspired sides, mustard and curry sauces, and sausage dishes including a chicken sausage tray bake.',
        ],
    ],

    'product_images' => [
        'the-regular' => '/images/products/regular-open-box.webp',
        'the-fling' => '/images/products/fling-open-box.webp',
        'the-big-gesture' => '/images/products/gift-open-box.webp',
        'classic-wieners' => '/images/food/classic-wieners-reference.webp',
        'bratwurst' => '/images/food/bratwurst-reference.webp',
        'cheese-kransky' => '/images/food/cheese-kransky-reference.webp',
    ],
];
