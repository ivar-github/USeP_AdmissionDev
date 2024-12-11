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
        'sortOrderB',
        'isActive',
        'parameterID',
        'evaltypeID',
        'placeHolder',
    ];

}
