<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCenter extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionTestCenter';

    public $timestamps = false;
    
    protected $fillable = [
          'campusID',
          'testCenterName',
          'description',
          'isActive',
    ];
}
