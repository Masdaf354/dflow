<div>
    <x-slot name="header">Repository Management</x-slot>

    <!-- Top Bar -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm mb-6">
        <div class="flex items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search repositories..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" />
            </div>
            <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Repository
            </button>
        </div>
    </div>

    <!-- Repositories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($repositories as $repo)
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-indigo-500/25">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">{{ $repo->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[180px]">{{ $repo->url ?? 'No URL' }}</p>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-1 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 py-1 z-10">
                            <button wire:click="openEditModal({{ $repo->id }})" @click="open = false" class="w-full text-left px-3 py-1.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700">Edit</button>
                            <button wire:click="confirmRepositoryDeletion({{ $repo->id }})" @click="open = false" class="w-full text-left px-3 py-1.5 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-slate-700">Delete</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 h-8">{{ $repo->description ?: 'No description provided.' }}</p>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $repo->is_active ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                        {{ $repo->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <span class="text-[10px] text-gray-400">{{ $repo->created_at->format('d M Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($repositories->isEmpty())
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-12 border border-gray-100 dark:border-slate-700 shadow-sm text-center">
            <div class="w-16 h-16 bg-gray-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">No repositories found</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Start by adding your first repository to the system.</p>
            <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Repository
            </button>
        </div>
    @endif

    <!-- Pagination -->
    @if($repositories->hasPages())
        <div class="mt-6">
            {{ $repositories->links() }}
        </div>
    @endif

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 p-6"
                 @keydown.escape.window="$wire.set('showModal', false)">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">{{ $isEdit ? 'Edit Repository' : 'Add Repository' }}</h3>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input wire:model="name" type="text" placeholder="e.g. Frontend Web App" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" />
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL (Optional)</label>
                        <input wire:model="url" type="text" placeholder="https://github.com/org/repo" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" />
                        @error('url') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (Optional)</label>
                        <textarea wire:model="description" rows="3" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" placeholder="Describe this repository..."></textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input wire:model="is_active" type="checkbox" id="is_active" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                        <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200">
                            {{ $isEdit ? 'Update Repository' : 'Add Repository' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Confirmation Modal -->
    <x-confirmation-modal 
        name="confirm-repo-deletion" 
        :show="$confirmingRepositoryDeletion !== null"
        title="Delete Repository"
        content="Are you sure you want to delete this repository? This action cannot be undone."
        confirmText="Delete Repository"
        wire:click="deleteRepository"
    />
</div>
