<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custom_ResultEnlistLogs extends Model
{
    // use HasFactory;
    protected $connection = 'CustomDB'; 
    protected $table = 'AdmissionResult_CourseEnlistmentLogs';

    protected $primaryKey = 'AppNo';
    public $incrementing = false;
    protected $keyType = 'string';

    // public $timestamps = false;

    protected $fillable = [
        'type',
        'TermID',
        'AppNo',
        'previousStatus',
        'previousCampusID',
        'previousCollegeID',
        'previousCourseID',
        'previousMajorID',
        'currentStatus',
        'currentCampusID',
        'currentCollegeID',
        'currentCourseID',
        'currentMajorID',
        'enlistedBy_userID',
        'enlistedBy_userEmail',
    ];
}
