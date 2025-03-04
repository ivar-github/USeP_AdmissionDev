<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleRoom extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionTestRoom';

    public $timestamps = false;
    
    protected $fillable = [
          'testRoomName',
          'description',
          'isActive',
    ];
}
