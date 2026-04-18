<?php

namespace App\Livewire;

use App\Models\ChangeLog;
use App\Models\ChangeRequest;
use Livewire\Component;

class ChangeRequestForm extends Component
{
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
    ];

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

            session()->flash('success', 'Change request created successfully.');
        }

        return redirect()->route('change-requests.index');
    }

    public function render()
    {
        return view('livewire.change-request-form');
    }
}
