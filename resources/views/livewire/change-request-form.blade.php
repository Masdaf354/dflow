<div>
    <x-slot name="header">{{ $isEdit ? 'Edit Change Request' : 'Create Change Request' }}</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm p-6">
            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input wire:model="title" type="text" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="Brief title for the change request" />
                        @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Description <span class="text-red-500">*</span></label>
                        <textarea wire:model="description" rows="4" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="Detailed description of the change"></textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Reason -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Reason <span class="text-red-500">*</span></label>
                        <textarea wire:model="reason" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="Why is this change needed?"></textarea>
                        @error('reason') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Change Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Change Type <span class="text-red-500">*</span></label>
                        <select wire:model="change_type" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @foreach(\App\Models\ChangeRequest::CHANGE_TYPES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('change_type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Priority <span class="text-red-500">*</span></label>
                        <select wire:model="priority" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @foreach(\App\Models\ChangeRequest::PRIORITIES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('priority') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Risk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Risk Level <span class="text-red-500">*</span></label>
                        <select wire:model="risk" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @foreach(\App\Models\ChangeRequest::RISKS as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('risk') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Affected Module -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Affected Module</label>
                        <input wire:model="affected_module" type="text" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="e.g. Authentication, Payment" />
                        @error('affected_module') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Target Release Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Target Release Date</label>
                        <input wire:model="target_release_date" type="date" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" />
                        @error('target_release_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Impact -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Impact Analysis</label>
                        <textarea wire:model="impact" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="What is the impact of this change?"></textarea>
                        @error('impact') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Rollback Plan -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Rollback Plan</label>
                        <textarea wire:model="rollback_plan" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="Steps to rollback if something goes wrong"></textarea>
                        @error('rollback_plan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Testing Plan -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Testing Plan</label>
                        <textarea wire:model="testing_plan" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200" placeholder="How will this change be tested?"></textarea>
                        @error('testing_plan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <!-- Images -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Attachments (Images)</label>
                        
                        <!-- Existing Images -->
                        @if($existingImages && count($existingImages) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @foreach($existingImages as $attachment)
                                    <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-slate-700">
                                        <img src="{{ $attachment->url }}" class="w-full h-full object-cover" alt="{{ $attachment->file_name }}">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                            <button type="button" wire:click="confirmImageDeletion({{ $attachment->id }})" class="p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-xl cursor-pointer bg-gray-50 dark:bg-slate-900 hover:bg-gray-100 dark:hover:bg-slate-800 transition-all duration-200">
                                <div wire:loading.remove wire:target="newImages" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-1 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG (MAX. 5MB)</p>
                                </div>
                                <div wire:loading wire:target="newImages" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="animate-spin w-8 h-8 mb-3 text-indigo-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Uploading...</p>
                                </div>
                                <input wire:model="newImages" type="file" multiple class="hidden" accept="image/*" />
                            </label>
                        </div>
                        @error('newImages.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

                        <!-- Preview New Images -->
                        @if($images)
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                @foreach($images as $index => $image)
                                    <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-slate-700">
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" wire:click="removeNewImage({{ $index }})" class="p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('change-requests.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:shadow-xl hover:shadow-indigo-500/30 flex items-center gap-2">
                        <svg wire:loading class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ $isEdit ? 'Update Change Request' : 'Create Change Request' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal 
        name="confirm-image-deletion" 
        :show="$confirmingImageDeletion !== null"
        title="Delete Image"
        content="Are you sure you want to delete this image? This action cannot be undone."
        confirmText="Delete Image"
        wire:click="deleteImage"
    />
</div>
