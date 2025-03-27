<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultRankingView extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'vw_CUSTOM_Admission_With_Ranking_Parameters';

    // protected $primaryKey = 'ProgID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
}
