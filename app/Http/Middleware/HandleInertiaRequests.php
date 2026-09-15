<?php

namespace App\Http\Middleware;

use App\Services\StorefrontCart;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => ['user' => $request->user()?->only('id', 'name', 'email')],
            'cart' => fn () => app(StorefrontCart::class)->summary(),
            'flash' => ['message' => fn () => $request->session()->get('message')],
            'launchMode' => true,
        ];
    }
}
