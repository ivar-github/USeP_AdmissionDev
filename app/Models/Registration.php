<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'ES_Admission';

    protected $primaryKey = 'AppNO';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'MobileNo'
    ];
}
