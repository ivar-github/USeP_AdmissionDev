<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    // use HasFactory;
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionQualifiedApplicantsOfficial';

    protected $primaryKey = 'AppNo';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'Status',
        'CampusID',
        'QualifiedCourse',
        'QualifiedCourseID',
        'QualifiedMajor',
        'QualifiedMajorID',
        'IsEnlisted',
        'EnlistmentDate',
    ];
}
