<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: false);
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-white mb-1">Welcome back</h2>
    <p class="text-sm text-slate-400 mb-6">Sign in to your account to continue</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus
                autocomplete="username"
                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600/50 rounded-xl text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
            <input wire:model="form.password" id="password" type="password" name="password" required
                autocomplete="current-password"
                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600/50 rounded-xl text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                    class="rounded border-slate-600 bg-slate-900/50 text-indigo-600 shadow-sm focus:ring-indigo-500/50 focus:ring-offset-0">
                <span class="ms-2 text-sm text-slate-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-400 hover:text-indigo-300 transition-colors duration-200"
                    href="{{ route('password.request') }}" wire:navigate>
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full mt-6 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:shadow-xl hover:shadow-indigo-500/30 flex items-center justify-center gap-2">
            <svg wire:loading class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Sign in
        </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center gap-3 mt-6">
        <div class="flex-1 h-px bg-slate-700"></div>
        <span class="text-xs text-slate-500 uppercase tracking-wider">or</span>
        <div class="flex-1 h-px bg-slate-700"></div>
    </div>

    <!-- Google Sign-in -->
    <a href="{{ route('google.redirect') }}"
        class="w-full mt-4 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-600/50 text-white text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-3">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Sign in with Google
    </a>

    @if (session('error'))
        <div class="mt-4 px-4 py-3 rounded-xl bg-red-900/30 border border-red-700/50 text-red-400 text-sm">
            {{ session('error') }}
        </div>
    @endif
</div>