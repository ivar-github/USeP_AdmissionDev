<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLogs extends Model
{
    protected $fillable = [
        'type',
        'userID',
        'userEmail',
        'module',
        'affectedID',
        'affectedItem',
        'description',
        'status',
    ];


    protected $casts = [
        'status' => 'boolean',
    ];
}
