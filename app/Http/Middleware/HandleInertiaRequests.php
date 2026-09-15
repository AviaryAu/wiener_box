<?php

namespace App\Http\Middleware;

use App\Services\StorefrontCart;
use App\Services\StorefrontSeo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'seo' => Inertia::always(fn () => app(StorefrontSeo::class)->forRequest($request)),
            'auth' => ['user' => $request->user()?->only('id', 'name', 'email')],
            'cart' => fn () => app(StorefrontCart::class)->summary(),
            'flash' => ['message' => fn () => $request->session()->get('message')],
            'launchMode' => config('storefront.launch_mode'),
        ];
    }
}
