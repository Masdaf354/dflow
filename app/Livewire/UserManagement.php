<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $editUserId = null;
    public ?int $confirmingUserDeletion = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'maker';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,maker,approver,developer',
        ];

        if (!$this->isEdit) {
            $rules['email'] .= '|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['email'] .= '|unique:users,email,' . $this->editUserId;
            $rules['password'] = 'nullable|string|min:8';
        }

        return $rules;
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'password', 'role', 'editUserId']);
        $this->isEdit = false;
        $this->role = 'maker';
        $this->showModal = true;
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->editUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->roles->first()?->name ?? 'maker';
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $user = User::findOrFail($this->editUserId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            if ($this->password) {
                $user->update(['password' => bcrypt($this->password)]);
            }

            $user->syncRoles([$this->role]);
            session()->flash('success', 'User updated successfully.');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'email_verified_at' => now(),
            ]);

            $user->assignRole($this->role);
            session()->flash('success', 'User created successfully.');
        }

        $this->showModal = false;
    }

    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion = $id;
        $this->dispatch('open-modal', 'confirm-user-deletion');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->confirmingUserDeletion);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();
        $this->confirmingUserDeletion = null;
        $this->dispatch('close-modal', 'confirm-user-deletion');
        session()->flash('success', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->with('roles')
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
