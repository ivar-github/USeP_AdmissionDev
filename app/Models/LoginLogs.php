<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLogs extends Model
{
    protected $fillable = [
        'userID',
        'userEmail',
        'description',
        'status',
        'hostName',
        'localIP',
        'location',
        'platform',
    ];


    protected $casts = [
        'status' => 'boolean',
    ];
}
