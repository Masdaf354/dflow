<div
    x-data="{
        messages: [],
        remove(message) {
            this.messages = this.messages.filter(m => m.id !== message.id)
        }
    }"
    @toast.window="
        let id = Date.now();
        messages.push({
            id: id,
            type: $event.detail.type || 'success',
            text: $event.detail.text,
            show: true
        });
        setTimeout(() => {
            let msg = messages.find(m => m.id === id);
            if (msg) remove(msg);
        }, 5000);
    "
    class="fixed top-5 left-1/2 -translate-x-1/2 z-[60] w-full max-w-sm px-4 space-y-4 pointer-events-none"
>
    <template x-for="message in messages" :key="message.id">
        <div
            x-show="message.show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="pointer-events-auto w-full bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl shadow-2xl p-4 flex items-center gap-3"
            :class="{
                'border-emerald-100 dark:border-emerald-900/30': message.type === 'success',
                'border-red-100 dark:border-red-900/30': message.type === 'error',
                'border-amber-100 dark:border-amber-900/30': message.type === 'warning',
                'border-blue-100 dark:border-blue-900/30': message.type === 'info',
            }"
        >
            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                :class="{
                    'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400': message.type === 'success',
                    'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400': message.type === 'error',
                    'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400': message.type === 'warning',
                    'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400': message.type === 'info',
                }"
            >
                <template x-if="message.type === 'success'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="message.type === 'error'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </template>
                <template x-if="message.type === 'warning'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </template>
                <template x-if="message.type === 'info'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </template>
            </div>
            
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800 dark:text-white" x-text="message.type.charAt(0).toUpperCase() + message.type.slice(1)"></p>
                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="message.text"></p>
            </div>

            <button @click="remove(message)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>
