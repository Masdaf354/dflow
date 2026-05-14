<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <!-- Google Account Connection -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="max-w-xl">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google Account
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Connect your Google account to enable one-click sign in. Your Google email must match your account email.
                </p>

                <div class="mt-4">
                    @if(auth()->user()->google_connected)
                        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Google account connected</p>
                                <p class="text-xs text-emerald-600 dark:text-emerald-400">You can sign in using Google</p>
                            </div>
                            <form method="POST" action="{{ route('google.disconnect') }}" onsubmit="return confirm('Are you sure you want to disconnect your Google account?')">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                    Disconnect
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700">
                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Not connected</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Connect to enable Google sign in</p>
                            </div>
                            <a href="{{ route('google.connect') }}" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24">
                                    <path fill="#fff" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                    <path fill="#fff" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#fff" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#fff" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Connect Google
                            </a>
                        </div>
                    @endif
                </div>

                @if(session('success'))
                    <div class="mt-3 px-4 py-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 text-emerald-600 dark:text-emerald-400 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-3 px-4 py-2 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-600 dark:text-red-400 text-sm">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
