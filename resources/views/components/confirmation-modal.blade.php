@props(['name', 'show' => false, 'title' => 'Are you sure?', 'content' => '', 'confirmText' => 'Confirm', 'type' => 'danger'])

<x-modal :name="$name" :show="$show" maxWidth="md">
    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $type === 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400' : 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' }}">
                @if($type === 'danger')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $title }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $content }}</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200">
                Cancel
            </button>
            <button {{ $attributes }} class="px-4 py-2 text-sm font-medium text-white rounded-xl shadow-lg transition-all duration-200 {{ $type === 'danger' ? 'bg-red-600 hover:bg-red-700 shadow-red-500/25' : 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-500/25' }}">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</x-modal>
