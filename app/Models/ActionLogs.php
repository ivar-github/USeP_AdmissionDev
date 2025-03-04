<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLogs extends Model
{
    protected $fillable = [
        'type',
        'module',
        'affectedID',
        'affectedItem',
        'description',
        'status',
        'userID',
        'userEmail',
        'hostName',
        'localIP',
        'location',
        'platform',
    ];


    protected $casts = [
        'status' => 'boolean',
    ];
}
