<?php

namespace Tests\Feature;

use App\Models\ProductListing;
use App\Models\User;
use App\Models\WaitlistEntry;
use Database\Seeders\PreviewBoxBrandingSeeder;
use Database\Seeders\PreviewPricingSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;
use Lunar\Admin\Models\Staff;
use Lunar\Base\CartSessionInterface;
use Lunar\Facades\CartSession;
use Lunar\FieldTypes\TranslatedText;
use Lunar\Models\Cart;
use Lunar\Models\Currency;
use Lunar\Models\CustomerGroup;
use Lunar\Models\Price;
use RuntimeException;
use Tests\TestCase;

class CommerceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->withoutVite();
    }

    public function test_catalogue_uses_lunar_prices_and_hides_unpublished_products(): void
    {
        $listing = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $this->get('/')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Home')->has('products', 3)
            ->where('products.0.name', 'The Big Wiener Club')->where('products.0.price', 5900)
            ->where('products.1.name', 'The Wurst Fling')->where('products.1.price', 6500)
            ->where('products.2.name', 'Nice Package')->where('products.2.price', 7900));
        $listing->product->variants->first()->prices->first()->update(['price' => 8100]);
        $this->get('/products/the-regular')->assertInertia(fn (Assert $page) => $page->where('product.price', 8100));
        $listing->update(['published' => false]);
        $this->get('/products/the-regular')->assertNotFound();
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 1])->assertNotFound();
    }

    public function test_guest_cart_uses_server_prices_and_supports_quantity_and_remove(): void
    {
        $listing = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 2, 'price' => 1])->assertRedirect()->assertSessionHasNoErrors();
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.subtotal', 11800)->where('cart.quantity', 2));
        $line = Cart::firstOrFail()->lines->first();
        $this->patch('/cart/'.$line->id, ['quantity' => 3])->assertRedirect();
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.subtotal', 17700));
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 12])->assertSessionHasErrors('quantity');
        $this->patch('/cart/'.$line->id, ['quantity' => 0])->assertSessionHasErrors('quantity');
        $this->delete('/cart/'.$line->id)->assertRedirect();
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.quantity', 0));
    }

    public function test_preview_pricing_refresh_updates_existing_catalogue_and_cart_without_changing_other_price_tiers(): void
    {
        $listing = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $listing->update(['story' => 'Owner-edited product story']);
        $variant = $listing->product->variants->first();
        $price = $variant->prices->first();
        $price->update(['price' => 7900]);
        $bulkPrice = Price::factory()->for($variant, 'priceable')->create([
            'currency_id' => $price->currency_id, 'min_quantity' => 6, 'price' => 5500,
        ]);
        $groupPrice = Price::factory()->for($variant, 'priceable')->create([
            'currency_id' => $price->currency_id, 'min_quantity' => 1, 'price' => 5400,
            'customer_group_id' => CustomerGroup::factory()->create()->id,
        ]);
        $foreignPrice = Price::factory()->for($variant, 'priceable')->create([
            'currency_id' => Currency::factory()->create(['code' => 'USD', 'default' => false])->id,
            'min_quantity' => 1, 'price' => 4500,
        ]);
        $priceCount = Price::count();
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 2]);

        $this->seed(PreviewPricingSeeder::class);
        $this->seed(PreviewPricingSeeder::class);

        $this->assertSame(5900, $price->fresh()->price->value);
        $this->assertSame(5500, $bulkPrice->fresh()->price->value);
        $this->assertSame(5400, $groupPrice->fresh()->price->value);
        $this->assertSame(4500, $foreignPrice->fresh()->price->value);
        $this->assertSame($priceCount, Price::count());
        $this->assertSame('Owner-edited product story', $listing->fresh()->story);
        $this->app->forgetInstance(CartSessionInterface::class);
        CartSession::clearResolvedInstance(CartSessionInterface::class);
        $this->get('/products/the-regular')->assertInertia(fn (Assert $page) => $page->where('product.price', 5900));
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.subtotal', 11800)->where('cart.lines.0.unitPrice', 5900));
    }

    public function test_preview_pricing_refresh_rolls_back_when_a_preview_variant_is_missing(): void
    {
        $price = ProductListing::where('slug', 'the-regular')->firstOrFail()->product->variants->first()->prices->first();
        $price->update(['price' => 7900]);
        ProductListing::where('slug', 'cheese-kransky')->firstOrFail()->product->variants->first()->update(['sku' => 'OWNER-CHEESE-KRANSKY']);

        $this->assertThrows(fn () => $this->seed(PreviewPricingSeeder::class), ModelNotFoundException::class);

        $this->assertSame(7900, $price->fresh()->price->value);
    }

    public function test_preview_pricing_refresh_rejects_production_without_changing_prices(): void
    {
        $price = ProductListing::where('slug', 'the-regular')->firstOrFail()->product->variants->first()->prices->first();
        $price->update(['price' => 7900]);
        $this->app->instance('env', 'production');

        $this->assertThrows(fn () => app(PreviewPricingSeeder::class)->run(), RuntimeException::class);

        $this->assertSame(7900, $price->fresh()->price->value);
    }

    public function test_box_branding_refresh_updates_names_and_taglines_without_replacing_product_data(): void
    {
        $listing = ProductListing::where('slug', 'the-regular')->firstOrFail();
        $listing->update(['eyebrow' => 'Old tagline', 'story' => 'Owner-edited product story']);
        $product = $listing->product;
        $attributes = $product->attribute_data;
        $attributes->put('name', new TranslatedText(['en' => 'The Regular', 'de' => 'Deutscher Club']));
        $product->update(['attribute_data' => $attributes]);
        $description = $product->translateAttribute('description');
        $price = $product->variants->first()->prices->first();
        $price->update(['price' => 6100]);
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 1]);

        $this->seed(PreviewBoxBrandingSeeder::class);
        $this->seed(PreviewBoxBrandingSeeder::class);

        $this->assertSame('Owner-edited product story', $listing->fresh()->story);
        $this->assertSame($description, $product->fresh()->translateAttribute('description'));
        $this->assertSame('Deutscher Club', $product->fresh()->translateAttribute('name', 'de'));
        $this->assertSame(6100, $price->fresh()->price->value);
        $this->assertDatabaseCount('product_listings', 6);
        $this->app->forgetInstance(CartSessionInterface::class);
        CartSession::clearResolvedInstance(CartSessionInterface::class);
        $this->get('/products/the-regular')->assertInertia(fn (Assert $page) => $page
            ->where('product.id', $listing->id)->where('product.name', 'The Big Wiener Club')
            ->where('product.eyebrow', 'Membership has its perks. Mostly sausages.'));
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page
            ->where('cart.lines.0.name', 'The Big Wiener Club')->where('cart.subtotal', 6100));
        $this->get('/products/the-fling')->assertInertia(fn (Assert $page) => $page
            ->where('product.name', 'The Wurst Fling')->where('product.eyebrow', 'Big flavour. No strings attached.'));
        $this->get('/products/the-big-gesture')->assertInertia(fn (Assert $page) => $page
            ->where('product.name', 'Nice Package')->where('product.eyebrow', 'Say it with sausages.'));
    }

    public function test_box_branding_refresh_rejects_production_without_changing_the_name(): void
    {
        $product = ProductListing::where('slug', 'the-regular')->firstOrFail()->product;
        $this->app->instance('env', 'production');

        $this->assertThrows(fn () => app(PreviewBoxBrandingSeeder::class)->run(), RuntimeException::class);

        $this->assertSame('The Big Wiener Club', $product->fresh()->translateAttribute('name'));
    }

    public function test_another_session_cannot_change_cart_lines(): void
    {
        $listing = ProductListing::firstOrFail();
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 1]);
        $line = Cart::firstOrFail()->lines->first();
        CartSession::forget(delete: false);
        $this->flushSession();
        $this->patch('/cart/'.$line->id, ['quantity' => 3])->assertNotFound();
        $this->delete('/cart/'.$line->id)->assertNotFound();
        $this->assertEquals(1, $line->fresh()->quantity);
    }

    public function test_signup_requires_consent_and_duplicate_cannot_overwrite_details(): void
    {
        $payload = ['email' => 'Taste@example.test', 'postcode' => '2000', 'interest' => 'subscription'];
        $this->post('/waitlist', $payload)->assertSessionHasErrors('consent');
        $this->assertDatabaseCount('waitlist_entries', 0);
        $this->post('/waitlist', $payload + ['consent' => true])->assertRedirect()->assertSessionHasNoErrors();
        $this->post('/waitlist', ['email' => 'taste@example.test', 'postcode' => '9999', 'interest' => 'gift', 'consent' => true])->assertRedirect();
        $this->assertDatabaseCount('waitlist_entries', 1);
        $this->assertDatabaseHas('waitlist_entries', ['email' => 'taste@example.test', 'postcode' => '2000', 'interest' => 'subscription']);
        $this->assertNotNull(WaitlistEntry::first()->consented_at);
    }

    public function test_delivery_is_never_presented_as_live_and_checkout_fails_closed(): void
    {
        $this->postJson('/delivery/check', ['postcode' => '2000'])->assertOk()->assertJson(['planned' => true, 'available' => false]);
        $this->postJson('/delivery/check', ['postcode' => '9999'])->assertOk()->assertJson(['planned' => false, 'available' => false]);
        $this->postJson('/delivery/check', ['postcode' => 'invalid'])->assertUnprocessable();
        $this->postJson('/checkout')->assertStatus(503);
        $this->postJson('/stripe/webhook', ['type' => 'invoice.paid'])->assertNotFound();
    }

    public function test_accounts_are_protected_and_guest_cart_survives_login_and_logout(): void
    {
        $this->get('/account')->assertRedirect('/login');
        $listing = ProductListing::firstOrFail();
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 1]);
        $this->post('/register', ['name' => 'Test Customer', 'email' => 'TEST@example.test', 'password' => 'Tasty-secret-123', 'password_confirmation' => 'Tasty-secret-123'])->assertRedirect('/account');
        $user = User::where('email', 'test@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('Tasty-secret-123', $user->password));
        $this->get('/account')->assertOk()->assertInertia(fn (Assert $page) => $page->has('orders', 0)->where('cart.quantity', 1));
        $this->assertDatabaseHas('lunar_carts', ['user_id' => $user->id]);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.quantity', 0));
        $this->post('/login', ['email' => $user->email, 'password' => 'Tasty-secret-123'])->assertRedirect('/account');
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.quantity', 1));
    }

    public function test_password_recovery_uses_tokens_and_does_not_reveal_accounts(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $message = 'If an account uses that email, we’ve sent a password reset link.';
        $this->post('/forgot-password', ['email' => $user->email])->assertSessionHas('message', $message);
        $this->post('/forgot-password', ['email' => 'unknown@example.test'])->assertSessionHas('message', $message);
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this->post('/reset-password', ['email' => $user->email, 'token' => $notification->token, 'password' => 'A-new-tasty-secret', 'password_confirmation' => 'A-new-tasty-secret'])->assertRedirect('/login');

            return true;
        });
        $this->assertTrue(Hash::check('A-new-tasty-secret', $user->fresh()->password));
    }

    public function test_store_customers_cannot_access_admin_and_custom_resources_require_owner(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create())->get('/admin')->assertRedirect('/admin/login');
        $staff = Staff::factory()->create(['admin' => false]);
        $owner = Staff::factory()->create(['admin' => true]);
        $this->assertFalse(Gate::forUser($staff)->allows('viewAny', WaitlistEntry::class));
        $this->assertTrue(Gate::forUser($owner)->allows('viewAny', WaitlistEntry::class));
        $this->actingAs($owner, 'staff')->get('/admin')->assertOk();
        $this->get('/admin/waitlist-entries')->assertOk();
        $this->get('/admin/delivery-areas')->assertOk();
        $this->get('/admin/product-listings')->assertOk();
    }
}
