<?php

namespace App\Livewire;

use App\Models\ChangeApproval;
use App\Models\ChangeDeployment;
use App\Models\ChangeDevelopment;
use App\Models\ChangeLog;
use App\Models\ChangeRequest;
use App\Models\User;
use Livewire\Component;

class ChangeRequestDetail extends Component
{
    public ChangeRequest $changeRequest;
    public string $approvalNotes = '';
    public string $gitBranch = '';
    public string $repository = '';
    public int $developerId = 0;
    public string $deployEnvironment = 'dev';
    public string $deployNotes = '';

    public function mount(ChangeRequest $changeRequest)
    {
        $this->changeRequest = $changeRequest;
        $this->gitBranch = $changeRequest->getGitBranchName();
        $this->repository = $changeRequest->developments()->first()?->repository ?? 'main-app';
    }

    public function submitForApproval()
    {
        if (!$this->changeRequest->canTransitionTo('submitted')) {
            session()->flash('error', 'Cannot submit this change request.');
            return;
        }

        $this->changeRequest->update(['status' => 'submitted']);

        ChangeLog::create([
            'change_request_id' => $this->changeRequest->id,
            'action' => 'submitted',
            'description' => 'Change request submitted for approval.',
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Change request submitted for approval.');
    }

    public function approve()
    {
        if (!$this->changeRequest->canTransitionTo('approved')) {
            session()->flash('error', 'Cannot approve this change request.');
            return;
        }

        ChangeApproval::create([
            'change_request_id' => $this->changeRequest->id,
            'approver_id' => auth()->id(),
            'status' => 'approved',
            'notes' => $this->approvalNotes,
            'approved_at' => now(),
        ]);

        $this->changeRequest->update(['status' => 'approved']);

        ChangeLog::create([
            'change_request_id' => $this->changeRequest->id,
            'action' => 'approved',
            'description' => 'Change request approved.' . ($this->approvalNotes ? ' Notes: ' . $this->approvalNotes : ''),
            'created_by' => auth()->id(),
        ]);

        $this->approvalNotes = '';
        session()->flash('success', 'Change request approved.');
    }

    public function reject()
    {
        if (!$this->changeRequest->canTransitionTo('rejected')) {
            session()->flash('error', 'Cannot reject this change request.');
            return;
        }

        ChangeApproval::create([
            'change_request_id' => $this->changeRequest->id,
            'approver_id' => auth()->id(),
            'status' => 'rejected',
            'notes' => $this->approvalNotes,
            'approved_at' => now(),
        ]);

        $this->changeRequest->update(['status' => 'rejected']);

        ChangeLog::create([
            'change_request_id' => $this->changeRequest->id,
            'action' => 'rejected',
            'description' => 'Change request rejected.' . ($this->approvalNotes ? ' Reason: ' . $this->approvalNotes : ''),
            'created_by' => auth()->id(),
        ]);

        $this->approvalNotes = '';
        session()->flash('success', 'Change request rejected.');
    }

    public function assignDeveloper()
    {
        if ($this->changeRequest->status === 'approved') {
            $this->changeRequest->update(['status' => 'in_progress']);
        }

        ChangeDevelopment::create([
            'change_request_id' => $this->changeRequest->id,
            'git_branch' => $this->gitBranch,
            'repository' => $this->repository,
            'developer_id' => $this->developerId ?: auth()->id(),
            'status' => 'in_progress',
        ]);

        ChangeLog::create([
            'change_request_id' => $this->changeRequest->id,
            'action' => 'developer_assigned',
            'description' => 'Developer assigned. Branch: ' . $this->gitBranch,
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Developer assigned successfully.');
    }

    public function transitionTo(string $status)
    {
        if (!$this->changeRequest->canTransitionTo($status)) {
            session()->flash('error', 'Invalid status transition.');
            return;
        }

        $oldStatus = $this->changeRequest->status;
        $this->changeRequest->update(['status' => $status]);

        ChangeLog::create([
            'change_request_id' => $this->changeRequest->id,
            'action' => 'status_changed',
            'description' => "Status changed from {$oldStatus} to {$status}.",
            'created_by' => auth()->id(),
        ]);

        session()->flash('success', 'Status updated to ' . ChangeRequest::STATUSES[$status] . '.');
    }

    public function deploy()
    {
        ChangeDeployment::create([
            'change_request_id' => $this->changeRequest->id,
            'environment' => $this->deployEnvironment,
            'status' => 'deployed',
            'deployed_by' => auth()->id(),
            'deployed_at' => now(),
            'notes' => $this->deployNotes,
        ]);

        ChangeLog::create([
            'change_request_id' => $this->changeRequest->id,
            'action' => 'deployed',
            'description' => 'Deployed to ' . strtoupper($this->deployEnvironment) . '.' . ($this->deployNotes ? ' Notes: ' . $this->deployNotes : ''),
            'created_by' => auth()->id(),
        ]);

        $this->deployNotes = '';
        session()->flash('success', 'Deployed to ' . strtoupper($this->deployEnvironment) . ' successfully.');
    }

    public function render()
    {
        $this->changeRequest->load(['creator', 'approvals.approver', 'developments.developer', 'deployments.deployedBy', 'logs.creator']);

        $developers = User::role('developer')->get();

        return view('livewire.change-request-detail', [
            'developers' => $developers,
        ]);
    }
}
