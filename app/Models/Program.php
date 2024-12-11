<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'ES_Programs';

    protected $primaryKey = 'ProgID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
}
