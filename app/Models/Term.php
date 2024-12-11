<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'ES_AYTerm';

    protected $primaryKey = 'TermID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
    
}
