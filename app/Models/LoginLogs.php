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
    ];


    protected $casts = [
        'status' => 'boolean',
    ];
}
