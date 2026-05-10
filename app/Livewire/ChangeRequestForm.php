<?php

namespace App\Livewire;

use App\Models\ChangeLog;
use App\Models\ChangeRequest;
use App\Models\ChangeRequestAttachment;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Livewire\WithFileUploads;

class ChangeRequestForm extends Component
{
    use WithFileUploads;

    public ?ChangeRequest $changeRequest = null;
    public bool $isEdit = false;

    public string $title = '';
    public string $description = '';
    public string $reason = '';
    public string $change_type = 'feature';
    public string $priority = 'medium';
    public string $impact = '';
    public string $risk = 'medium';
    public string $rollback_plan = '';
    public string $testing_plan = '';
    public string $affected_module = '';
    public ?string $target_release_date = null;

    public $images = []; // This will now accumulate images
    public $newImages = []; // This will be used for the wire:model binding
    public $existingImages = [];
    public ?int $confirmingImageDeletion = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'reason' => 'required|string',
        'change_type' => 'required|in:feature,bugfix,hotfix,enhancement,refactor,security',
        'priority' => 'required|in:low,medium,high,critical',
        'impact' => 'nullable|string',
        'risk' => 'required|in:low,medium,high,critical',
        'rollback_plan' => 'nullable|string',
        'testing_plan' => 'nullable|string',
        'affected_module' => 'nullable|string|max:255',
        'target_release_date' => 'nullable|date',
        'newImages.*' => 'nullable|image|max:5120', // Max 5MB
    ];

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:5120',
        ]);

        if (is_array($this->newImages)) {
            foreach ($this->newImages as $image) {
                $this->images[] = $image;
            }
        } else {
            $this->images[] = $this->newImages;
        }

        $this->newImages = [];
    }

    public function removeNewImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function mount(?ChangeRequest $changeRequest = null)
    {
        if ($changeRequest && $changeRequest->exists) {
            $this->changeRequest = $changeRequest;
            $this->isEdit = true;
            $this->title = $changeRequest->title;
            $this->description = $changeRequest->description;
            $this->reason = $changeRequest->reason;
            $this->change_type = $changeRequest->change_type;
            $this->priority = $changeRequest->priority;
            $this->impact = $changeRequest->impact ?? '';
            $this->risk = $changeRequest->risk;
            $this->rollback_plan = $changeRequest->rollback_plan ?? '';
            $this->testing_plan = $changeRequest->testing_plan ?? '';
            $this->affected_module = $changeRequest->affected_module ?? '';
            $this->target_release_date = $changeRequest->target_release_date?->format('Y-m-d');
            $this->existingImages = $changeRequest->attachments;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'reason' => $this->reason,
            'change_type' => $this->change_type,
            'priority' => $this->priority,
            'impact' => $this->impact,
            'risk' => $this->risk,
            'rollback_plan' => $this->rollback_plan,
            'testing_plan' => $this->testing_plan,
            'affected_module' => $this->affected_module,
            'target_release_date' => $this->target_release_date,
        ];

        if ($this->isEdit) {
            $this->changeRequest->update($data);

            ChangeLog::create([
                'change_request_id' => $this->changeRequest->id,
                'action' => 'updated',
                'description' => 'Change request updated.',
                'created_by' => auth()->id(),
            ]);

            $this->saveImages($this->changeRequest);

            session()->flash('success', 'Change request updated successfully.');
        } else {
            $data['code'] = ChangeRequest::generateCode();
            $data['status'] = 'draft';
            $data['created_by'] = auth()->id();

            $cr = ChangeRequest::create($data);

            ChangeLog::create([
                'change_request_id' => $cr->id,
                'action' => 'created',
                'description' => 'Change request created.',
                'created_by' => auth()->id(),
            ]);

            $this->saveImages($cr);

            session()->flash('success', 'Change request created successfully.');
        }

        return redirect()->route('change-requests.index');
    }

    protected function saveImages(ChangeRequest $cr)
    {
        foreach ($this->images as $image) {
            $path = $image->store('change-requests/' . $cr->id, 'public');
            $cr->attachments()->create([
                'file_path' => $path,
                'file_name' => $image->getClientOriginalName(),
                'file_type' => $image->getMimeType(),
            ]);
        }
        $this->images = [];
    }

    public function confirmImageDeletion($id)
    {
        $this->confirmingImageDeletion = $id;
        $this->dispatch('open-modal', 'confirm-image-deletion');
    }

    public function deleteImage()
    {
        $attachment = ChangeRequestAttachment::findOrFail($this->confirmingImageDeletion);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
        $this->confirmingImageDeletion = null;
        $this->dispatch('close-modal', 'confirm-image-deletion');
        $this->existingImages = $this->changeRequest->attachments()->get();
    }

    public function render()
    {
        return view('livewire.change-request-form');
    }
}
