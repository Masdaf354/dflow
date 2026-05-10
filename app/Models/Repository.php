<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = [
        'name',
        'url',
        'description',
        'is_active',
    ];
}
