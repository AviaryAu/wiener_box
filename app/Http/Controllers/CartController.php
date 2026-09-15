<?php

namespace App\Http\Controllers;

use App\Models\ProductListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Lunar\Facades\CartSession;

class CartController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Cart');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['product_id' => 'required|integer|exists:product_listings,id', 'quantity' => 'required|integer|min:1|max:12']);
        $listing = ProductListing::with('product.variants')->findOrFail($data['product_id']);
        abort_unless($listing->published && $listing->product->status === 'published', 404);
        $variant = $listing->product->variants->firstOrFail();
        $existing = CartSession::current()?->lines->first(fn ($line) => $line->purchasable_id === $variant->id);
        if (($existing?->quantity ?? 0) + $data['quantity'] > config('storefront.cart_quantity_limit')) {
            throw ValidationException::withMessages(['quantity' => 'Please choose up to 12 of each item.']);
        }
        CartSession::manager()->add($variant, $data['quantity']);

        return back()->with('message', 'Added to your box. Looking good!');
    }

    public function update(Request $request, int $line): RedirectResponse
    {
        $data = $request->validate(['quantity' => 'required|integer|min:1|max:12']);
        $cart = CartSession::current();
        abort_unless($cart?->lines->contains('id', $line), 404);
        $cart->updateLine($line, $data['quantity']);

        return back()->with('message', 'Your box is updated.');
    }

    public function destroy(int $line): RedirectResponse
    {
        $cart = CartSession::current();
        abort_unless($cart?->lines->contains('id', $line), 404);
        $cart->remove($line);

        return back()->with('message', 'Item removed.');
    }
}
