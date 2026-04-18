<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Change Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">

            <!-- Left Panel - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute inset-0">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-600/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-3xl"></div>
                </div>

                <!-- Grid pattern overlay -->
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center w-full px-12">
                    <!-- Logo -->
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl shadow-indigo-500/30 mb-8">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>

                    <h1 class="text-4xl font-bold text-white mb-3 text-center">Change Management</h1>
                    <p class="text-lg text-slate-400 text-center max-w-md mb-12">Tools for tracking requests, approvals, development, and deployment of application changes.</p>

                    <!-- Feature pills -->
                    <div class="flex flex-wrap justify-center gap-3">
                        <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/80 border border-slate-700/50 backdrop-blur-sm">
                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                            <span class="text-sm text-slate-300">Change Requests</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/80 border border-slate-700/50 backdrop-blur-sm">
                            <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                            <span class="text-sm text-slate-300">Workflow Tracking</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/80 border border-slate-700/50 backdrop-blur-sm">
                            <div class="w-2 h-2 rounded-full bg-purple-400"></div>
                            <span class="text-sm text-slate-300">Deployment Pipeline</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/80 border border-slate-700/50 backdrop-blur-sm">
                            <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                            <span class="text-sm text-slate-300">Approval Engine</span>
                        </div>
                    </div>

                    <!-- Workflow diagram -->
                    <div class="mt-12 flex items-center gap-2 opacity-50">
                        @foreach(['Draft', 'Submit', 'Approve', 'Develop', 'Deploy', 'Done'] as $i => $step)
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-slate-700/60 border border-slate-600/50 flex items-center justify-center text-xs font-medium text-slate-400">{{ $i + 1 }}</div>
                                @if($i < 5)
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Panel - Auth Form -->
            <div class="flex-1 flex flex-col justify-center items-center bg-slate-900 px-6 py-12 lg:px-8">
                <!-- Mobile Logo (shown on small screens) -->
                <div class="lg:hidden mb-8 flex flex-col items-center">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl shadow-indigo-500/30 mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Change Management</h2>
                </div>

                <div class="w-full sm:max-w-md">
                    <div class="bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-2xl shadow-black/20 px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
