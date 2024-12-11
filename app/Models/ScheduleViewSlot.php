<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleViewSlot extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'vw_CUSTOM_AdmissionTestSchedule';

}
