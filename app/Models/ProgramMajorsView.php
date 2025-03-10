<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramMajorsView extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'vw_CUSTOM_AllProgramsAndMajors';

    // protected $primaryKey = 'ProgID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
}
