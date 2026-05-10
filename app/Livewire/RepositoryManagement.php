<?php

namespace App\Livewire;

use App\Models\Repository;
use Livewire\Component;
use Livewire\WithPagination;

class RepositoryManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $editRepositoryId = null;
    public ?int $confirmingRepositoryDeletion = null;

    public string $name = '';
    public string $url = '';
    public string $description = '';
    public bool $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'url' => 'nullable|url|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function openCreateModal()
    {
        $this->reset(['name', 'url', 'description', 'is_active', 'editRepositoryId']);
        $this->isEdit = false;
        $this->is_active = true;
        $this->showModal = true;
    }

    public function openEditModal($repositoryId)
    {
        $repository = Repository::findOrFail($repositoryId);
        $this->editRepositoryId = $repository->id;
        $this->name = $repository->name;
        $this->url = $repository->url ?? '';
        $this->description = $repository->description ?? '';
        $this->is_active = (bool) $repository->is_active;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $repository = Repository::findOrFail($this->editRepositoryId);
            $repository->update([
                'name' => $this->name,
                'url' => $this->url,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('success', 'Repository updated successfully.');
        } else {
            Repository::create([
                'name' => $this->name,
                'url' => $this->url,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('success', 'Repository created successfully.');
        }

        $this->showModal = false;
    }

    public function confirmRepositoryDeletion($id)
    {
        $this->confirmingRepositoryDeletion = $id;
        $this->dispatch('open-modal', 'confirm-repo-deletion');
    }

    public function deleteRepository()
    {
        $repository = Repository::findOrFail($this->confirmingRepositoryDeletion);
        $repository->delete();
        $this->confirmingRepositoryDeletion = null;
        $this->dispatch('close-modal', 'confirm-repo-deletion');
        session()->flash('success', 'Repository deleted successfully.');
    }

    public function render()
    {
        $repositories = Repository::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.repository-management', [
            'repositories' => $repositories,
        ]);
    }
}
