<div>
    <x-slot name="header">User Management</x-slot>

    <!-- Top Bar -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-gray-100 dark:border-slate-700 shadow-sm mb-6">
        <div class="flex items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search users..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" />
            </div>
            <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add User
            </button>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($users as $user)
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-indigo-500/25">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">{{ $user->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-1 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 py-1 z-10">
                            <button wire:click="openEditModal({{ $user->id }})" @click="open = false" class="w-full text-left px-3 py-1.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700">Edit</button>
                            @if($user->id !== auth()->id())
                                <button wire:click="confirmUserDeletion({{ $user->id }})" @click="open = false" class="w-full text-left px-3 py-1.5 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-slate-700">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-2">
                    @foreach($user->roles as $role)
                        @php
                            $roleColors = [
                                'admin' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                'maker' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                'approver' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                'developer' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $roleColors[$role->name] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($role->name) }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between text-xs text-gray-400">
                    <span>Joined {{ $user->created_at->format('d M Y') }}</span>
                    <span>{{ $user->changeRequests()->count() ?? 0 }} CRs</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50" x-data x-init="document.body.style.overflow = 'hidden'" x-on:remove="document.body.style.overflow = 'auto'">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 p-6"
                 x-trap="true"
                 @keydown.escape.window="$wire.set('showModal', false)">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">{{ $isEdit ? 'Edit User' : 'Create User' }}</h3>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input wire:model="name" type="text" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" />
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input wire:model="email" type="email" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" />
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password {{ $isEdit ? '(Leave blank to keep current)' : '' }}</label>
                        <input wire:model="password" type="password" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500" />
                        @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select wire:model="role" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500">
                            <option value="admin">Admin</option>
                            <option value="maker">Maker</option>
                            <option value="approver">Approver</option>
                            <option value="developer">Developer</option>
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200">
                            {{ $isEdit ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Confirmation Modal -->
    <x-confirmation-modal 
        name="confirm-user-deletion" 
        :show="$confirmingUserDeletion !== null"
        title="Delete User"
        content="Are you sure you want to delete this user? This action cannot be undone."
        confirmText="Delete User"
        wire:click="deleteUser"
    />
</div>
