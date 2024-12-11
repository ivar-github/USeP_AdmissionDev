<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvalRating extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_CourseEvalRating';

    protected $primaryKey = 'id';
    // public $incrementing = false;
    // protected $keyType = 'string';

    // public $timestamps = false;

    protected $fillable = [
        'description',
        'rating',
        'isActive',
        'alias',
        'sortOrder',
        'evalTemplateID',
    ];

}
