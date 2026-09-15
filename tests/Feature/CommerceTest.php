<?php

namespace Tests\Feature;

use App\Models\ProductListing;
use App\Models\User;
use App\Models\WaitlistEntry;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Inertia\Testing\AssertableInertia as Assert;
use Lunar\Admin\Models\Staff;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
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
        $this->get('/')->assertOk()->assertInertia(fn (Assert $page) => $page->component('Home')->has('products', 3)->where('products.0.price', 7900));
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
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.subtotal', 15800)->where('cart.quantity', 2));
        $line = Cart::firstOrFail()->lines->first();
        $this->patch('/cart/'.$line->id, ['quantity' => 3])->assertRedirect();
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.subtotal', 23700));
        $this->post('/cart', ['product_id' => $listing->id, 'quantity' => 12])->assertSessionHasErrors('quantity');
        $this->patch('/cart/'.$line->id, ['quantity' => 0])->assertSessionHasErrors('quantity');
        $this->delete('/cart/'.$line->id)->assertRedirect();
        $this->get('/cart')->assertInertia(fn (Assert $page) => $page->where('cart.quantity', 0));
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
