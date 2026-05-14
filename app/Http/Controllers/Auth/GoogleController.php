<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth (for login).
     */
    public function redirect()
    {
        session(['google_auth_action' => 'login']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect to Google to connect account (from profile).
     */
    public function connectRedirect()
    {
        session(['google_auth_action' => 'connect']);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Single callback handler — routes based on session action.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            $fallback = Auth::check() ? 'profile' : 'login';
            return redirect()->route($fallback)
                ->with('error', 'Google authentication failed. Please try again.');
        }

        $action = session()->pull('google_auth_action', 'login');

        if ($action === 'connect') {
            return $this->handleConnect($googleUser);
        }

        return $this->handleLogin($googleUser);
    }

    /**
     * Handle Google login.
     */
    protected function handleLogin($googleUser)
    {
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'No account found with this email. Please contact your administrator.');
        }

        if (!$user->google_connected) {
            return redirect()->route('login')
                ->with('error', 'Google login is not enabled for your account. Please connect your Google account in Profile settings first.');
        }

        if ($user->google_id && $user->google_id !== $googleUser->getId()) {
            return redirect()->route('login')
                ->with('error', 'This Google account does not match your connected account.');
        }

        Auth::login($user, remember: true);
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Handle Google account connection from profile.
     */
    protected function handleConnect($googleUser)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login and try again.');
        }

        $user = Auth::user();

        $existing = User::where('google_id', $googleUser->getId())
            ->where('id', '!=', $user->id)
            ->first();

        if ($existing) {
            return redirect()->route('profile')
                ->with('error', 'This Google account is already connected to another user.');
        }

        if ($googleUser->getEmail() !== $user->email) {
            return redirect()->route('profile')
                ->with('error', 'Google account email (' . $googleUser->getEmail() . ') does not match your account email (' . $user->email . ').');
        }

        $user->update([
            'google_id' => $googleUser->getId(),
            'google_connected' => true,
        ]);

        return redirect()->route('profile')
            ->with('success', 'Google account connected successfully! You can now sign in with Google.');
    }

    /**
     * Disconnect Google account from profile.
     */
    public function disconnect()
    {
        Auth::user()->update([
            'google_id' => null,
            'google_connected' => false,
        ]);

        return redirect()->route('profile')
            ->with('success', 'Google account disconnected.');
    }
}
