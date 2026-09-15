<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LaunchController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/shop', [StorefrontController::class, 'shop'])->name('shop');
Route::get('/products/{listing}', [StorefrontController::class, 'product'])->name('product');
Route::get('/delivery', fn () => Inertia::render('Delivery'))->name('delivery');
Route::post('/delivery/check', [LaunchController::class, 'check'])->middleware('throttle:30,1');
Route::post('/waitlist', [LaunchController::class, 'waitlist'])->middleware('throttle:5,1');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store'])->middleware('throttle:60,1')->block();
Route::patch('/cart/{line}', [CartController::class, 'update'])->whereNumber('line')->block();
Route::delete('/cart/{line}', [CartController::class, 'destroy'])->whereNumber('line')->block();
Route::post('/checkout', fn () => response()->json(['message' => 'Orders are not open yet. Join the launch list for updates.'], 503))->middleware('throttle:10,1');
Route::get('/how-it-works', fn () => Inertia::render('HowItWorks'))->name('how-it-works');
Route::get('/privacy', fn () => Inertia::render('Privacy'))->name('privacy');
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Auth', ['mode' => 'login']))->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
    Route::get('/register', fn () => Inertia::render('Auth', ['mode' => 'register']))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::get('/forgot-password', fn () => Inertia::render('Auth', ['mode' => 'forgot']))->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgot'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/reset-password/{token}', fn (Request $request, string $token) => Inertia::render('Auth', ['mode' => 'reset', 'token' => $token, 'email' => $request->query('email')]))->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->middleware('throttle:5,1')->name('password.update');
});
Route::middleware('auth')->group(function () {
    Route::get('/account', [AuthController::class, 'account'])->name('account');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
