<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvalParameter extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_CourseEvalParameter';

    protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'desc',
        'sortOrderN',
        'sortOrderA',
        'isActive',
        'dateAdded',
        'evalTypeID',
    ];

}
