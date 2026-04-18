<?php

namespace App\Livewire;

use App\Models\ChangeRequest;
use Livewire\Component;

class KanbanBoard extends Component
{
    public function render()
    {
        $columns = [
            'draft' => ['label' => 'Draft', 'color' => 'gray', 'icon' => 'pencil'],
            'submitted' => ['label' => 'Submitted', 'color' => 'blue', 'icon' => 'paper-airplane'],
            'approved' => ['label' => 'Approved', 'color' => 'green', 'icon' => 'check-circle'],
            'in_progress' => ['label' => 'In Progress', 'color' => 'yellow', 'icon' => 'code-bracket'],
            'code_review' => ['label' => 'Code Review', 'color' => 'purple', 'icon' => 'eye'],
            'merged' => ['label' => 'Merged', 'color' => 'indigo', 'icon' => 'arrow-path'],
            'deployed' => ['label' => 'Deployed', 'color' => 'teal', 'icon' => 'cloud-arrow-up'],
            'done' => ['label' => 'Done', 'color' => 'emerald', 'icon' => 'check-badge'],
        ];

        $changeRequests = [];
        foreach (array_keys($columns) as $status) {
            $changeRequests[$status] = ChangeRequest::where('status', $status)
                ->with('creator')
                ->orderBy('priority', 'desc')
                ->get();
        }

        return view('livewire.kanban-board', [
            'columns' => $columns,
            'changeRequests' => $changeRequests,
        ]);
    }
}
