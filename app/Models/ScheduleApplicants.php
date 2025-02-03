<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleApplicants extends Model
{

    protected $connection = 'sqlsrv2';
    protected $table = 'CUSTOM_AdmissionApplicantTestSchedule';

    protected $fillable = [
        // 'MobileNo'
    ];
}
