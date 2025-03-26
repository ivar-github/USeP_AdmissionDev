<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultOverallView extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'vw_CUSTOM_Admission_With_Over_All_Ranking';

    // protected $primaryKey = 'ProgID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
}
