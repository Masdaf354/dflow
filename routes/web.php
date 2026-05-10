<?php

use App\Livewire\ChangeRequestDetail;
use App\Livewire\ChangeRequestForm;
use App\Livewire\ChangeRequestList;
use App\Livewire\Dashboard;
use App\Livewire\DeploymentTracker;
use App\Livewire\KanbanBoard;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Change Requests
    Route::get('change-requests', ChangeRequestList::class)->name('change-requests.index');
    Route::get('change-requests/create', ChangeRequestForm::class)->name('change-requests.create');
    Route::get('change-requests/{changeRequest}/edit', ChangeRequestForm::class)->name('change-requests.edit');
    Route::get('change-requests/{changeRequest}', ChangeRequestDetail::class)->name('change-requests.show');

    // Kanban Board
    Route::get('kanban', KanbanBoard::class)->name('kanban');

    // Deployments
    Route::get('deployments', DeploymentTracker::class)->name('deployments');

    // Git Documentation
    Route::get('git-docs', \App\Livewire\GitDocumentation::class)->name('git-docs');

    // User Management (Admin only)
    Route::get('users', UserManagement::class)->name('users.index')->middleware('role:admin');
    Route::get('repositories', \App\Livewire\RepositoryManagement::class)->name('repositories.index')->middleware('role:admin');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
