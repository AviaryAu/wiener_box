<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Lunar\Facades\CartSession;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'These details don’t match our records.']);
        }
        $request->session()->regenerate();

        return redirect()->intended('/account');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $data = $request->validate(['name' => 'required|string|max:120', 'email' => 'required|email|max:254|unique:users', 'password' => ['required', 'confirmed', PasswordRule::min(12)]]);
        Auth::login(User::create($data));
        $request->session()->regenerate();

        return redirect('/account');
    }

    public function logout(Request $request): RedirectResponse
    {
        CartSession::forget(delete: false);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function forgot(Request $request): RedirectResponse
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $data = $request->validate(['email' => 'required|email']);
        Password::sendResetLink($data);

        return back()->with('message', 'If an account uses that email, we’ve sent a password reset link.');
    }

    public function reset(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => 'required|email', 'token' => 'required|string', 'password' => ['required', 'confirmed', PasswordRule::min(12)]]);
        $status = Password::reset($data, function (User $user, string $password) {
            $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
            event(new PasswordReset($user));
        });
        if ($status !== Password::PasswordReset) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        return redirect('/login')->with('message', 'Password updated. You can sign in now.');
    }

    public function account(Request $request): Response
    {
        $orders = $request->user()->orders()->whereNotNull('placed_at')->latest()->limit(20)->get()->map(fn ($order) => [
            'reference' => $order->reference, 'status' => $order->status,
            'total' => $order->total->value, 'placedAt' => $order->placed_at->format('d M Y'),
        ]);

        return Inertia::render('Account', ['orders' => $orders]);
    }
}
