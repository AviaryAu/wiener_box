<?php

namespace App\Http\Controllers;

use App\Models\ProductListing;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Inertia\Response;

class StorefrontController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', ['products' => $this->products()->where('featured', true)->get()->map->storefrontData()]);
    }

    public function shop(): Response
    {
        return Inertia::render('Shop', ['products' => $this->products()->get()->map->storefrontData()]);
    }

    public function product(ProductListing $listing): Response
    {
        abort_unless($listing->published && $listing->product->status === 'published', 404);
        $listing->load('product.variants.prices.currency');

        return Inertia::render('Product', ['product' => $listing->storefrontData()]);
    }

    private function products(): Builder
    {
        return ProductListing::where('published', true)->whereHas('product', fn ($query) => $query->where('status', 'published'))->with('product.variants.prices.currency')->orderBy('position');
    }
}
