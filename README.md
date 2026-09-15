# Wiener Box

A playful German-style sausage storefront built with **Laravel 13, Vue 3, Inertia 2, Lunar 1.5 and Filament 4**. Laravel owns commerce and customer accounts. Cashier is installed for the next Stripe billing increment.

## Local preview

The current workspace is set up at **http://127.0.0.1:8000**. Admin: **http://127.0.0.1:8000/admin**.

A local owner account has randomly generated credentials in `storage/app/private/preview-admin.json`. This file is private, ignored by Git and never shipped as a default production account. To create it on a fresh local installation, run `php artisan wiener:preview-admin`. For production staff, use `php artisan lunar:create-admin` interactively.

### Fresh local setup

Requires PHP 8.3+ with the extensions Composer checks, Composer, Node 22.12+ and npm.

```sh
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed
php artisan filament:assets
npm ci
npm run build
php artisan wiener:preview-admin
php artisan serve --host=127.0.0.1 --port=8000
```

Only copy the example environment on a fresh installation. Keep existing secrets when upgrading. Run `npm run dev` in another terminal for live frontend editing. Local password-reset messages go to `storage/logs/laravel.log`; configure a real mail transport before public use.

The preview seeder is local/testing only and idempotent: it does not overwrite staff edits. It creates six illustrative products and five proposed postcode records, with zero claimed inventory and no fake orders. Never use these prices, recipes or tax defaults as approved retail data.

## Working now

- Branded responsive home, catalogue filters/search, product detail, gifts and subscription offer pages.
- Lunar database cart with server prices, quantity limits, guest sessions and account association.
- Registration, login, logout, password reset and private order history.
- Postcode planning check and a consented launch list saved to the database.
- Native Lunar commerce admin plus storefront listings, delivery areas and launch-list management.
- Separate staff authentication; production staff MFA and owner-only access to custom business data.

**This is a prelaunch implementation.** Checkout is disabled. Cashier routes are disabled. No payments, recurring renewals, carrier tracking, marketing campaigns or live supplier imports are connected. Final supplier data, stock/lot handling, billing, delivery enforcement and public legal/contact details are required before launch. See the blueprint for the next milestones.

## Checks

```sh
php artisan test --compact
npm run typecheck
npm run build
npx playwright install chromium
npm run test:browser
vendor/bin/pint --format agent
npm run format:check
```

Browser tests expect the local server and seeded preview catalogue. Set `PREVIEW_URL` for a different local port. `PLAYWRIGHT_CHROMIUM_EXECUTABLE` can select an existing compatible browser. The optional admin test uses the local credentials file; it skips when the file is absent. Browser tests change only their own preview cart and read admin records. PHP feature tests use an isolated in-memory database.

## Project guides

- [Design guidelines](docs/design-guidelines.md): typography, palette, component rules, imagery, language and accessibility.
- [Commerce blueprint](docs/commerce-blueprint.md): Laravel-native architecture, current capabilities, all purchase/renewal/admin journeys and launch gates.
- [Business plan](docs/business-plan.md): supplier strategy, viability, operations, social media, budget and pilot plan.
- [Brand direction](docs/brand-direction.md): original mascot and creative territory.
- [Financial model](outputs/business-plan/wiener-box-financial-model.xlsx): original scenario; reforecast for the selected Stripe/Laravel backend before relying on funding outputs.

Design tokens live in `resources/css/tokens.css`. Shared Vue components live in `resources/js/components`; pages in `resources/js/Pages`. Web-optimised artwork is in `public/images`, with original PNGs retained beside it. Desktop/mobile/admin screenshots are in `outputs/implementation`.

Laravel Cloud is the intended host. This increment has not been deployed or connected to production services.
