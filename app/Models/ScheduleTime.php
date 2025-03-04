<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleTime extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionTestTime';

    public $timestamps = false;

    protected $fillable = [
        'testTimeStartString',
        'testTimeEndString',
        'testTimeStart',
        'testTimeEnd',
        'isActive',
    ];
}
