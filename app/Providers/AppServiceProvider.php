<?php

namespace App\Providers;

use App\Filament\Resources\DeliveryAreaResource;
use App\Filament\Resources\ProductListingResource;
use App\Filament\Resources\WaitlistEntryResource;
use App\Models\DeliveryArea;
use App\Models\ProductListing;
use App\Models\WaitlistEntry;
use App\Policies\BusinessDataPolicy;
use Filament\FontProviders\LocalFontProvider;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Lunar\Admin\Support\Facades\LunarPanel;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Cashier::ignoreRoutes();
        LunarPanel::forceTwoFactorAuth($this->app->isProduction())->panel(fn (Panel $panel) => $panel
            ->favicon(asset('favicon.svg'))->path('admin')->brandName('Wiener Box')->brandLogo(null)->darkModeBrandLogo(null)
            ->font('DM Sans', url: asset('fonts/brand.css'), provider: LocalFontProvider::class)
            ->colors(['primary' => Color::Amber])
            ->resources([
                WaitlistEntryResource::class,
                DeliveryAreaResource::class,
                ProductListingResource::class,
            ])
        )->register();
    }

    public function boot(): void
    {
        foreach ([DeliveryArea::class, ProductListing::class, WaitlistEntry::class] as $model) {
            Gate::policy($model, BusinessDataPolicy::class);
        }
        RateLimiter::for('login', fn (Request $request) => [
            Limit::perMinute(20)->by($request->ip()),
            Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip()),
        ]);
    }
}
