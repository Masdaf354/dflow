<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'reason',
        'change_type',
        'priority',
        'impact',
        'risk',
        'rollback_plan',
        'testing_plan',
        'affected_module',
        'target_release_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'target_release_date' => 'date',
    ];

    public const STATUSES = [
        'draft' => 'Draft',
        'submitted' => 'Submitted',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'in_progress' => 'In Progress',
        'code_review' => 'Code Review',
        'merged' => 'Merged',
        'deployed' => 'Deployed',
        'done' => 'Done',
        'cancelled' => 'Cancelled',
    ];

    public const CHANGE_TYPES = [
        'feature' => 'Feature',
        'bugfix' => 'Bug Fix',
        'hotfix' => 'Hot Fix',
        'enhancement' => 'Enhancement',
        'refactor' => 'Refactor',
        'security' => 'Security',
    ];

    public const PRIORITIES = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'critical' => 'Critical',
    ];

    public const RISKS = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'critical' => 'Critical',
    ];

    public const STATUS_COLORS = [
        'draft' => 'gray',
        'submitted' => 'blue',
        'approved' => 'green',
        'rejected' => 'red',
        'in_progress' => 'yellow',
        'code_review' => 'purple',
        'merged' => 'indigo',
        'deployed' => 'teal',
        'done' => 'emerald',
        'cancelled' => 'red',
    ];

    public const WORKFLOW = [
        'draft' => ['submitted', 'cancelled'],
        'submitted' => ['approved', 'rejected'],
        'approved' => ['in_progress', 'cancelled'],
        'rejected' => ['draft'],
        'in_progress' => ['code_review', 'cancelled'],
        'code_review' => ['merged', 'in_progress'],
        'merged' => ['deployed'],
        'deployed' => ['done'],
        'done' => [],
        'cancelled' => ['draft'],
    ];

    public static function generateCode(): string
    {
        $latest = static::latest('id')->first();
        $nextNumber = $latest ? $latest->id + 1 : 1;
        return 'CR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function canTransitionTo(string $status): bool
    {
        return in_array($status, self::WORKFLOW[$this->status] ?? []);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvals()
    {
        return $this->hasMany(ChangeApproval::class);
    }

    public function developments()
    {
        return $this->hasMany(ChangeDevelopment::class);
    }

    public function deployments()
    {
        return $this->hasMany(ChangeDeployment::class);
    }

    public function logs()
    {
        return $this->hasMany(ChangeLog::class)->orderBy('created_at', 'desc');
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getGitBranchName(): string
    {
        $prefix = match($this->change_type) {
            'bugfix', 'hotfix' => 'bugfix',
            default => 'feature',
        };
        return $prefix . '/' . $this->code;
    }
}
