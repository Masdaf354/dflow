<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeDeployment extends Model
{
    protected $fillable = [
        'change_request_id',
        'environment',
        'status',
        'deployed_by',
        'deployed_at',
        'notes',
    ];

    protected $casts = [
        'deployed_at' => 'datetime',
    ];

    public const ENVIRONMENTS = [
        'staging' => 'SIT',
        'uat' => 'UAT',
        'production' => 'PRODUCTION',
    ];

    public const STATUSES = [
        'pending' => 'Pending',
        'deploying' => 'Deploying',
        'deployed' => 'Deployed',
        'failed' => 'Failed',
        'rolled_back' => 'Rolled Back',
    ];

    public function changeRequest()
    {
        return $this->belongsTo(ChangeRequest::class);
    }

    public function deployedBy()
    {
        return $this->belongsTo(User::class, 'deployed_by');
    }
}
