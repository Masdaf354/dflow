<div>
    <x-slot name="header">Dashboard</x-slot>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <!-- Total CRs -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total CRs</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalCRs }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pending Approval</p>
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $pendingApproval }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">In Progress</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $inProgress }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
        </div>

        <!-- Deployed -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Deployed</p>
                    <p class="text-3xl font-bold text-teal-600 dark:text-teal-400 mt-1">{{ $deployed }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/25 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
            </div>
        </div>

        <!-- Done -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Completed</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $done }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Status Distribution Chart -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Change Status Distribution</h3>
            <div class="h-64">
                <canvas id="statusChart" wire:ignore></canvas>
            </div>
        </div>

        <!-- Priority Distribution Chart -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Priority Distribution</h3>
            <div class="h-64">
                <canvas id="priorityChart" wire:ignore></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- High Risk Changes -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                High Risk Changes
            </h3>
            <div class="space-y-3">
                @forelse($highRiskChanges as $cr)
                    <a href="{{ route('change-requests.show', $cr) }}" class="block p-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-mono text-red-600 dark:text-red-400">{{ $cr->code }}</span>
                                <p class="text-sm font-medium text-gray-800 dark:text-white mt-0.5">{{ $cr->title }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $cr->risk === 'critical' ? 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300' : 'bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300' }}">
                                {{ ucfirst($cr->risk) }} Risk
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No high risk changes found.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Recent Activity
            </h3>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($recentLogs as $log)
                    <div class="flex items-start gap-3 p-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">
                            {{ substr($log->creator->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 dark:text-gray-200">
                                <span class="font-medium">{{ $log->creator->name ?? 'System' }}</span>
                                <span class="text-gray-500 dark:text-gray-400">{{ $log->description }}</span>
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs font-mono text-indigo-600 dark:text-indigo-400">{{ $log->changeRequest->code ?? 'N/A' }}</span>
                                <span class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No recent activity.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Charts Script -->
    <script wire:ignore>
        document.addEventListener('livewire:navigated', initCharts);
        document.addEventListener('DOMContentLoaded', initCharts);

        function initCharts() {
            // Status Chart
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                if (statusCtx._chart) statusCtx._chart.destroy();
                const statusData = @json($statusCounts);
                const statusLabels = Object.keys(statusData).map(s => s.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()));
                const statusColors = ['#94a3b8', '#3b82f6', '#22c55e', '#ef4444', '#eab308', '#a855f7', '#6366f1', '#14b8a6', '#10b981', '#ef4444'];

                statusCtx._chart = new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: Object.values(statusData),
                            backgroundColor: statusColors.slice(0, statusLabels.length),
                            borderWidth: 0,
                            spacing: 2,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    padding: 12,
                                    usePointStyle: true,
                                    pointStyleWidth: 8,
                                    font: { size: 11, family: 'Inter' }
                                }
                            }
                        },
                        cutout: '65%',
                    }
                });
            }

            // Priority Chart
            const priorityCtx = document.getElementById('priorityChart');
            if (priorityCtx) {
                if (priorityCtx._chart) priorityCtx._chart.destroy();
                const priorityData = @json($priorityCounts);
                const priorityColors = {
                    low: '#22c55e',
                    medium: '#3b82f6',
                    high: '#f59e0b',
                    critical: '#ef4444'
                };

                priorityCtx._chart = new Chart(priorityCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(priorityData).map(p => p.charAt(0).toUpperCase() + p.slice(1)),
                        datasets: [{
                            label: 'Change Requests',
                            data: Object.values(priorityData),
                            backgroundColor: Object.keys(priorityData).map(p => priorityColors[p] || '#94a3b8'),
                            borderWidth: 0,
                            borderRadius: 8,
                            barPercentage: 0.6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, font: { size: 11, family: 'Inter' } },
                                grid: { color: 'rgba(148, 163, 184, 0.1)' }
                            },
                            x: {
                                ticks: { font: { size: 11, family: 'Inter' } },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        }
    </script>
</div>
