<?php

namespace App\Services;

use App\Models\ProductListing;
use Lunar\Facades\CartSession;

class StorefrontCart
{
    public function summary(): array
    {
        $cart = CartSession::current();
        if (! $cart || $cart->lines->isEmpty()) {
            return ['lines' => [], 'quantity' => 0, 'subtotal' => 0, 'deliveryEstimate' => config('storefront.delivery_estimate')];
        }
        $listings = ProductListing::whereIn('product_id', $cart->lines->map(fn ($line) => $line->purchasable?->product_id))->get()->keyBy('product_id');
        $lines = $cart->lines->map(function ($line) use ($listings) {
            $listing = $listings->get($line->purchasable?->product_id);

            return [
                'id' => $line->id,
                'name' => $line->purchasable?->product?->translateAttribute('name') ?? 'Unavailable product',
                'slug' => $listing?->slug, 'cadence' => $listing?->cadence,
                'colour' => $listing?->colour ?? 'sage', 'quantity' => $line->quantity,
                'unitPrice' => $line->unitPrice->value, 'total' => $line->subTotal->value,
                'available' => (bool) $listing?->published && $line->purchasable?->product?->status === 'published',
            ];
        })->values();

        return ['lines' => $lines, 'quantity' => $lines->sum('quantity'), 'subtotal' => $cart->subTotal->value, 'deliveryEstimate' => config('storefront.delivery_estimate')];
    }
}
