<?php

namespace App\Livewire;

use App\Models\ChangeDeployment;
use App\Models\ChangeRequest;
use Livewire\Component;

class DeploymentTracker extends Component
{
    public function render()
    {
        $deployments = ChangeDeployment::with(['changeRequest', 'deployedBy'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('change_request_id');

        $changeRequests = ChangeRequest::whereIn('status', ['merged', 'deployed', 'done'])
            ->with(['deployments.deployedBy'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('livewire.deployment-tracker', [
            'changeRequests' => $changeRequests,
        ]);
    }
}
