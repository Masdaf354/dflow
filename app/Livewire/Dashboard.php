<?php

namespace App\Livewire;

use App\Models\ChangeDeployment;
use App\Models\ChangeRequest;
use App\Models\ChangeLog;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalCRs = ChangeRequest::count();
        $pendingApproval = ChangeRequest::where('status', 'submitted')->count();
        $inProgress = ChangeRequest::where('status', 'in_progress')->count();
        $deployed = ChangeRequest::where('status', 'deployed')->count();
        $done = ChangeRequest::where('status', 'done')->count();

        // Status distribution for chart
        $statusCounts = ChangeRequest::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Priority distribution
        $priorityCounts = ChangeRequest::selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        // High risk changes
        $highRiskChanges = ChangeRequest::where('risk', 'high')
            ->orWhere('risk', 'critical')
            ->whereNotIn('status', ['done', 'cancelled'])
            ->with('creator')
            ->latest()
            ->limit(5)
            ->get();

        // Recent activity
        $recentLogs = ChangeLog::with(['changeRequest', 'creator'])
            ->latest()
            ->limit(10)
            ->get();

        // Deployment stats
        $deploymentStats = ChangeDeployment::selectRaw('environment, status, count(*) as count')
            ->groupBy('environment', 'status')
            ->get();

        return view('livewire.dashboard', [
            'totalCRs' => $totalCRs,
            'pendingApproval' => $pendingApproval,
            'inProgress' => $inProgress,
            'deployed' => $deployed,
            'done' => $done,
            'statusCounts' => $statusCounts,
            'priorityCounts' => $priorityCounts,
            'highRiskChanges' => $highRiskChanges,
            'recentLogs' => $recentLogs,
            'deploymentStats' => $deploymentStats,
        ]);
    }
}
