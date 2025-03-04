<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleSlot extends Model
{

    protected $connection = 'sqlsrv2';
    protected $table = 'CUSTOM_AdmissionTestSchedule';

    public $timestamps = false;
    
    protected $fillable = [
        'testCenterID',
        'testDateID',
        'testTimeID',
        'testRoomID',
        'testSessionID',
        'termID',
        'maxExamineeSlots',
        'dateAdded',
        'createdBy',
        'isActive',
    ];
}
