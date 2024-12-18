<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvalRemark extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_CourseEvalParameterQuestion';

    protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'question',
        'sortOrderN',
        'sortOrderA',
        'isActive',
        'parameterID',
        'evalTypeID',
        'placeHolder',
    ];

}
