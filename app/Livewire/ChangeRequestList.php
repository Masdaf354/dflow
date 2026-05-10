<?php

namespace App\Livewire;

use App\Models\ChangeLog;
use App\Models\ChangeRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ChangeRequestList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $typeFilter = '';
    public string $priorityFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public ?int $confirmingDeletion = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDeletion($id)
    {
        $this->confirmingDeletion = $id;
        $this->dispatch('open-modal', 'confirm-cr-deletion');
    }

    public function deleteChangeRequest()
    {
        $cr = ChangeRequest::findOrFail($this->confirmingDeletion);

        if ($cr->status !== 'draft') {
            session()->flash('error', 'Only draft change requests can be deleted.');
            return;
        }

        $cr->delete();
        $this->confirmingDeletion = null;
        $this->dispatch('close-modal', 'confirm-cr-deletion');
        session()->flash('success', 'Change request deleted successfully.');
    }

    public function render()
    {
        $changeRequests = ChangeRequest::query()
            ->with('creator')
            ->withCount('attachments')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('title', 'like', '%' . $this->search . '%')
                        ->orWhere('affected_module', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->typeFilter, fn($q) => $q->where('change_type', $this->typeFilter))
            ->when($this->priorityFilter, fn($q) => $q->where('priority', $this->priorityFilter))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.change-request-list', [
            'changeRequests' => $changeRequests,
        ]);
    }
}
