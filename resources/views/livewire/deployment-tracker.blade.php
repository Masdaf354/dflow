<div>
    <x-slot name="header">Deployment Tracker</x-slot>

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-900/50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Change Request</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">DEV</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">UAT</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">STAGING</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">PRODUCTION</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($changeRequests as $cr)
                        @php
                            $deployments = $cr->deployments->keyBy('environment');
                            $environments = ['dev', 'uat', 'staging', 'production'];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <a href="{{ route('change-requests.show', $cr) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span class="font-mono text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $cr->code }}</span>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white mt-0.5">{{ Str::limit($cr->title, 50) }}</p>
                                </a>
                            </td>

                            @foreach($environments as $env)
                                <td class="px-6 py-4 text-center">
                                    @if(isset($deployments[$env]))
                                        @php
                                            $dep = $deployments[$env];
                                            $envStatusColors = [
                                                'deployed' => 'text-emerald-500',
                                                'deploying' => 'text-yellow-500 animate-pulse',
                                                'failed' => 'text-red-500',
                                                'rolled_back' => 'text-orange-500',
                                                'pending' => 'text-gray-400',
                                            ];
                                        @endphp
                                        <div class="flex flex-col items-center">
                                            @if($dep->status === 'deployed')
                                                <svg class="w-6 h-6 {{ $envStatusColors[$dep->status] ?? '' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                            @elseif($dep->status === 'failed')
                                                <svg class="w-6 h-6 {{ $envStatusColors[$dep->status] ?? '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            @elseif($dep->status === 'deploying')
                                                <svg class="w-6 h-6 {{ $envStatusColors[$dep->status] ?? '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            @else
                                                <svg class="w-6 h-6 {{ $envStatusColors[$dep->status] ?? '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @endif
                                            <span class="text-xs text-gray-400 mt-1">{{ $dep->deployed_at?->format('d/m H:i') }}</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <div class="w-6 h-6 rounded-full border-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                                            <span class="text-xs text-gray-300 dark:text-gray-600 mt-1">Pending</span>
                                        </div>
                                    @endif
                                </td>
                            @endforeach

                            <td class="px-6 py-4 text-center">
                                @php
                                    $crStatusStyles = [
                                        'merged' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400',
                                        'deployed' => 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400',
                                        'done' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $crStatusStyles[$cr->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ \App\Models\ChangeRequest::STATUSES[$cr->status] ?? $cr->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">No deployments yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Environment Legend -->
    <div class="mt-6 bg-white dark:bg-slate-800 rounded-2xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm">
        <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Legend</h4>
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                <span class="text-sm text-gray-600 dark:text-gray-400">Deployed</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span class="text-sm text-gray-600 dark:text-gray-400">Deploying</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span class="text-sm text-gray-600 dark:text-gray-400">Failed</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 rounded-full border-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Pending</span>
            </div>
        </div>
    </div>
</div>
