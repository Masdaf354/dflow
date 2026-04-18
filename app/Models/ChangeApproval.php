<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeApproval extends Model
{
    protected $fillable = [
        'change_request_id',
        'approver_id',
        'status',
        'notes',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function changeRequest()
    {
        return $this->belongsTo(ChangeRequest::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
