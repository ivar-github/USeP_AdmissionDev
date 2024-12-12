<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvalStatement extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_CourseEvalBenchmarkStatement';

    protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'statement',
        'dateAdded',
        'desc',
        'isActive',
        'sortOrder',
        'evalTypeID',
        'parameterID',
        'versionID',
        'ratingTemplateID',
    ];

}
