<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequestAttachment extends Model
{
    protected $fillable = [
        'change_request_id',
        'file_path',
        'file_name',
        'file_type',
    ];

    public function changeRequest()
    {
        return $this->belongsTo(ChangeRequest::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
