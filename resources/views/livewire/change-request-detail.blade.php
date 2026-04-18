<div>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('change-requests.index') }}" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <span class="font-mono text-indigo-600 dark:text-indigo-400">{{ $changeRequest->code }}</span>
            <span class="text-gray-300 dark:text-gray-600">—</span>
            {{ $changeRequest->title }}
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Status & Workflow Bar -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Workflow Status</h3>
                    @php
                        $statusStyles = [
                            'draft' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
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
                    <span class="px-3 py-1.5 rounded-xl text-sm font-semibold {{ $statusStyles[$changeRequest->status] ?? '' }}">
                        {{ \App\Models\ChangeRequest::STATUSES[$changeRequest->status] ?? $changeRequest->status }}
                    </span>
                </div>

                <!-- Visual Progress -->
                @php
                    $workflowSteps = ['draft', 'submitted', 'approved', 'in_progress', 'code_review', 'merged', 'deployed', 'done'];
                    $currentIndex = array_search($changeRequest->status, $workflowSteps);
                    if ($currentIndex === false) $currentIndex = -1;
                @endphp
                <div class="flex items-center gap-1 overflow-x-auto pb-2">
                    @foreach($workflowSteps as $index => $step)
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300
                                    {{ $index <= $currentIndex ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/25' : 'bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-gray-500' }}">
                                    @if($index < $currentIndex)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <span class="text-xs mt-1 {{ $index <= $currentIndex ? 'text-indigo-600 dark:text-indigo-400 font-medium' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ \App\Models\ChangeRequest::STATUSES[$step] ?? $step }}
                                </span>
                            </div>
                            @if(!$loop->last)
                                <div class="w-6 h-0.5 mt-[-16px] {{ $index < $currentIndex ? 'bg-indigo-500' : 'bg-gray-200 dark:bg-slate-700' }}"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-gray-100 dark:border-slate-700">
                    @foreach(\App\Models\ChangeRequest::WORKFLOW[$changeRequest->status] ?? [] as $nextStatus)
                        @if($nextStatus === 'submitted')
                            <button wire:click="submitForApproval" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25">
                                Submit for Approval
                            </button>
                        @elseif($nextStatus === 'approved')
                            {{-- Handled in sidebar --}}
                        @elseif($nextStatus === 'rejected')
                            {{-- Handled in sidebar --}}
                        @elseif($nextStatus === 'cancelled')
                            <button wire:click="transitionTo('cancelled')" wire:confirm="Are you sure you want to cancel this change request?" class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium rounded-xl hover:bg-red-200 dark:hover:bg-red-900/50 transition-all duration-200">
                                Cancel Request
                            </button>
                        @else
                            <button wire:click="transitionTo('{{ $nextStatus }}')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/25">
                                Move to {{ \App\Models\ChangeRequest::STATUSES[$nextStatus] ?? $nextStatus }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Details -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Change Type</label>
                        <p class="mt-1 text-sm text-gray-800 dark:text-gray-200">{{ \App\Models\ChangeRequest::CHANGE_TYPES[$changeRequest->change_type] ?? $changeRequest->change_type }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</label>
                        @php
                            $priorityColors = [
                                'low' => 'text-green-600 dark:text-green-400',
                                'medium' => 'text-blue-600 dark:text-blue-400',
                                'high' => 'text-amber-600 dark:text-amber-400',
                                'critical' => 'text-red-600 dark:text-red-400',
                            ];
                        @endphp
                        <p class="mt-1 text-sm font-semibold {{ $priorityColors[$changeRequest->priority] ?? '' }}">{{ ucfirst($changeRequest->priority) }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Risk Level</label>
                        <p class="mt-1 text-sm font-semibold {{ $priorityColors[$changeRequest->risk] ?? '' }}">{{ ucfirst($changeRequest->risk) }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Affected Module</label>
                        <p class="mt-1 text-sm text-gray-800 dark:text-gray-200">{{ $changeRequest->affected_module ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Target Release</label>
                        <p class="mt-1 text-sm text-gray-800 dark:text-gray-200">{{ $changeRequest->target_release_date?->format('d M Y') ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Git Branch</label>
                        <p class="mt-1 text-sm font-mono text-indigo-600 dark:text-indigo-400">{{ $changeRequest->getGitBranchName() }}</p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $changeRequest->description }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reason</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $changeRequest->reason }}</p>
                    </div>
                    @if($changeRequest->impact)
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Impact Analysis</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $changeRequest->impact }}</p>
                    </div>
                    @endif
                    @if($changeRequest->rollback_plan)
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rollback Plan</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $changeRequest->rollback_plan }}</p>
                    </div>
                    @endif
                    @if($changeRequest->testing_plan)
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Testing Plan</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $changeRequest->testing_plan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Activity Timeline</h3>
                <div class="space-y-4">
                    @foreach($changeRequest->logs as $log)
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ substr($log->creator->name ?? 'S', 0, 1) }}
                                </div>
                                @if(!$loop->last)
                                    <div class="w-0.5 flex-1 bg-gray-200 dark:bg-slate-700 mt-2"></div>
                                @endif
                            </div>
                            <div class="pb-4">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    <span class="font-medium">{{ $log->creator->name ?? 'System' }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ $log->description }}</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Info Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Created by</span>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($changeRequest->creator->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $changeRequest->creator->name ?? 'Unknown' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Created</span>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{ $changeRequest->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Updated</span>
                        <span class="text-sm text-gray-800 dark:text-gray-200">{{ $changeRequest->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Approval Panel (for Submitted status) -->
            @if($changeRequest->status === 'submitted')
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-blue-200 dark:border-blue-800/50 shadow-sm">
                    <h3 class="text-sm font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Approval Required
                    </h3>
                    <div class="space-y-3">
                        <textarea wire:model="approvalNotes" rows="3" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" placeholder="Add notes..."></textarea>
                        <div class="flex gap-2">
                            <button wire:click="approve" class="flex-1 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl transition-all duration-200">
                                Approve
                            </button>
                            <button wire:click="reject" class="flex-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-all duration-200">
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Approval History -->
            @if($changeRequest->approvals->isNotEmpty())
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Approvals</h3>
                    <div class="space-y-3">
                        @foreach($changeRequest->approvals as $approval)
                            <div class="p-3 rounded-xl {{ $approval->status === 'approved' ? 'bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30' : 'bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30' }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $approval->approver->name ?? 'Unknown' }}</span>
                                    <span class="text-xs font-medium {{ $approval->status === 'approved' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ ucfirst($approval->status) }}
                                    </span>
                                </div>
                                @if($approval->notes)
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $approval->notes }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $approval->approved_at?->diffForHumans() ?? $approval->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Developer Assignment (for Approved status) -->
            @if(in_array($changeRequest->status, ['approved', 'in_progress']))
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Assign Developer</h3>
                    <div class="space-y-3">
                        <select wire:model="developerId" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500">
                            <option value="0">Select Developer</option>
                            @foreach($developers as $dev)
                                <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                            @endforeach
                        </select>
                        <input wire:model="gitBranch" type="text" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm font-mono text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" placeholder="Git branch" />
                        <input wire:model="repository" type="text" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" placeholder="Repository" />
                        <button wire:click="assignDeveloper" class="w-full px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-all duration-200">
                            Assign
                        </button>
                    </div>
                </div>
            @endif

            <!-- Development Info -->
            @if($changeRequest->developments->isNotEmpty())
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Development</h3>
                    <div class="space-y-3">
                        @foreach($changeRequest->developments as $dev)
                            <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($dev->developer->name ?? 'D', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $dev->developer->name ?? 'Unknown' }}</span>
                                </div>
                                <p class="text-xs font-mono text-indigo-600 dark:text-indigo-400 mt-1">{{ $dev->git_branch }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $dev->repository }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Deployment (for Merged/Deployed status) -->
            @if(in_array($changeRequest->status, ['merged', 'deployed']))
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Deploy</h3>
                    <div class="space-y-3">
                        <select wire:model="deployEnvironment" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500">
                            @foreach(\App\Models\ChangeDeployment::ENVIRONMENTS as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea wire:model="deployNotes" rows="2" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" placeholder="Deployment notes..."></textarea>
                        <button wire:click="deploy" class="w-full px-3 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-xl transition-all duration-200">
                            Deploy
                        </button>
                    </div>
                </div>
            @endif

            <!-- Deployment History -->
            @if($changeRequest->deployments->isNotEmpty())
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-100 dark:border-slate-700 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Deployment History</h3>
                    <div class="space-y-2">
                        @foreach($changeRequest->deployments as $deployment)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-slate-900/50">
                                <div>
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ strtoupper($deployment->environment) }}</span>
                                    <p class="text-xs text-gray-400">{{ $deployment->deployed_at?->format('d M Y H:i') }}</p>
                                </div>
                                <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $deployment->status === 'deployed' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }}">
                                    {{ ucfirst($deployment->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
