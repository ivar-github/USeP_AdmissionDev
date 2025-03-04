<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionTestDate';

    public $timestamps = false;

    protected $fillable = [
        'testDate',
        'isActive',
    ];
}
