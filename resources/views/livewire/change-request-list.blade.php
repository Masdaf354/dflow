<div>
    <x-slot name="header">Change Requests</x-slot>

    <!-- Top Bar -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm mb-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <!-- Search -->
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by code, title, module..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" />
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-3 flex-wrap">
                <select wire:model.live="statusFilter" class="px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500">
                    <option value="">All Status</option>
                    @foreach(\App\Models\ChangeRequest::STATUSES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <select wire:model.live="typeFilter" class="px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500">
                    <option value="">All Types</option>
                    @foreach(\App\Models\ChangeRequest::CHANGE_TYPES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <select wire:model.live="priorityFilter" class="px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500">
                    <option value="">All Priority</option>
                    @foreach(\App\Models\ChangeRequest::PRIORITIES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <a href="{{ route('change-requests.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:shadow-xl hover:shadow-indigo-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Request
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-900/50">
                        <th wire:click="sortBy('code')" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <div class="flex items-center gap-1">
                                Code
                                @if($sortField === 'code')
                                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14l5-5 5 5z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('title')" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <div class="flex items-center gap-1">
                                Title
                                @if($sortField === 'title')
                                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14l5-5 5 5z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk</th>
                        <th wire:click="sortBy('status')" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <div class="flex items-center gap-1">
                                Status
                                @if($sortField === 'status')
                                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14l5-5 5 5z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Creator</th>
                        <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <div class="flex items-center gap-1">
                                Date
                                @if($sortField === 'created_at')
                                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14l5-5 5 5z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($changeRequests as $cr)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $cr->code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('change-requests.show', $cr) }}" class="text-sm font-medium text-gray-800 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ Str::limit($cr->title, 40) }}</a>
                                    @if($cr->attachments_count > 0)
                                        <div class="flex items-center gap-0.5 text-gray-400" title="{{ $cr->attachments_count }} attachments">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            <span class="text-[10px] font-medium">{{ $cr->attachments_count }}</span>
                                        </div>
                                    @endif
                                </div>
                                @if($cr->affected_module)
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $cr->affected_module }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                    {{ \App\Models\ChangeRequest::CHANGE_TYPES[$cr->change_type] ?? $cr->change_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $priorityColors = [
                                        'low' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                        'medium' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                        'high' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                                        'critical' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $priorityColors[$cr->priority] ?? '' }}">
                                    {{ ucfirst($cr->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $riskColors = [
                                        'low' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                        'medium' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                        'high' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
                                        'critical' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $riskColors[$cr->risk] ?? '' }}">
                                    {{ ucfirst($cr->risk) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusStyles = [
                                        'draft' => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300',
                                        'submitted' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                        'approved' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                        'rejected' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                        'in_progress' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                        'code_review' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                        'merged' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400',
                                        'deployed' => 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400',
                                        'done' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                        'cancelled' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusStyles[$cr->status] ?? '' }}">
                                    {{ \App\Models\ChangeRequest::STATUSES[$cr->status] ?? $cr->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($cr->creator->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $cr->creator->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $cr->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('change-requests.show', $cr) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all duration-200" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    @if($cr->status === 'draft')
                                        <a href="{{ route('change-requests.edit', $cr) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition-all duration-200" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button wire:click="confirmDeletion({{ $cr->id }})" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-all duration-200" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                     @endif
                                 </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">No change requests found.</p>
                                    <a href="{{ route('change-requests.create') }}" class="mt-3 text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Create your first change request →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($changeRequests->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700">
                {{ $changeRequests->links() }}
            </div>
        @endif
    </div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal 
        name="confirm-cr-deletion" 
        :show="$confirmingDeletion !== null"
        title="Delete Change Request"
        content="Are you sure you want to delete this change request? This action cannot be undone."
        confirmText="Delete Request"
        wire:click="deleteChangeRequest"
    />
</div>
