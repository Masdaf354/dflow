<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');

    // Google OAuth - redirect for login
    Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    // Google Account Connect/Disconnect (Profile)
    Route::get('auth/google/connect', [GoogleController::class, 'connectRedirect'])->name('google.connect');
    Route::post('auth/google/disconnect', [GoogleController::class, 'disconnect'])->name('google.disconnect');
});

Route::post('logout', function () {
    auth()->guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// Google OAuth callback (shared - works for both login and connect)
Route::get('auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
