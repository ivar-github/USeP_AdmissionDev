<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleSession extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionTestSession';

    protected $fillable = [
        // 'MobileNo'
    ];
}