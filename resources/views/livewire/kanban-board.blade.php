<div>
    <x-slot name="header">Kanban Board</x-slot>

    <div class="flex gap-4 overflow-x-auto pb-4 min-h-[calc(100vh-12rem)]">
        @foreach($columns as $status => $column)
            <div class="flex-shrink-0 w-72">
                <!-- Column Header -->
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        @php
                            $headerColors = [
                                'draft' => 'text-gray-600 dark:text-gray-400',
                                'submitted' => 'text-blue-600 dark:text-blue-400',
                                'approved' => 'text-green-600 dark:text-green-400',
                                'in_progress' => 'text-yellow-600 dark:text-yellow-400',
                                'code_review' => 'text-purple-600 dark:text-purple-400',
                                'merged' => 'text-indigo-600 dark:text-indigo-400',
                                'deployed' => 'text-teal-600 dark:text-teal-400',
                                'done' => 'text-emerald-600 dark:text-emerald-400',
                            ];
                            $dotColors = [
                                'draft' => 'bg-gray-400',
                                'submitted' => 'bg-blue-500',
                                'approved' => 'bg-green-500',
                                'in_progress' => 'bg-yellow-500',
                                'code_review' => 'bg-purple-500',
                                'merged' => 'bg-indigo-500',
                                'deployed' => 'bg-teal-500',
                                'done' => 'bg-emerald-500',
                            ];
                        @endphp
                        <div class="w-2.5 h-2.5 rounded-full {{ $dotColors[$status] ?? 'bg-gray-400' }}"></div>
                        <h3 class="text-sm font-semibold {{ $headerColors[$status] ?? 'text-gray-600' }}">{{ $column['label'] }}</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400">
                        {{ $changeRequests[$status]->count() }}
                    </span>
                </div>

                <!-- Column Body -->
                <div class="space-y-3 min-h-[200px] p-2 rounded-2xl bg-gray-100/50 dark:bg-slate-800/50 border border-gray-200/50 dark:border-slate-700/50">
                    @foreach($changeRequests[$status] as $cr)
                        <a href="{{ route('change-requests.show', $cr) }}" class="block bg-white dark:bg-slate-800 rounded-xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer group">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-mono font-semibold text-indigo-600 dark:text-indigo-400">{{ $cr->code }}</span>
                                @php
                                    $priorityBadge = [
                                        'low' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                        'medium' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                        'high' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                                        'critical' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="px-1.5 py-0.5 rounded text-xs font-medium {{ $priorityBadge[$cr->priority] ?? '' }}">
                                    {{ ucfirst($cr->priority) }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h4 class="text-sm font-medium text-gray-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200 line-clamp-2 mb-2">
                                {{ $cr->title }}
                            </h4>

                            <!-- Tags -->
                            <div class="flex items-center gap-2 flex-wrap mb-3">
                                <span class="px-2 py-0.5 rounded text-xs bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                    {{ \App\Models\ChangeRequest::CHANGE_TYPES[$cr->change_type] ?? $cr->change_type }}
                                </span>
                                @if($cr->affected_module)
                                    <span class="px-2 py-0.5 rounded text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                        {{ $cr->affected_module }}
                                    </span>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($cr->creator->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $cr->creator->name ?? 'Unknown' }}</span>
                                </div>
                                @if($cr->target_release_date)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $cr->target_release_date->format('d M') }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
