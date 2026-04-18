<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeDevelopment extends Model
{
    protected $fillable = [
        'change_request_id',
        'git_branch',
        'repository',
        'developer_id',
        'status',
    ];

    public function changeRequest()
    {
        return $this->belongsTo(ChangeRequest::class);
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}
