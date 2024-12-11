<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCenter extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionTestCenter';

    protected $fillable = [
        // 'MobileNo'
    ];
}
