<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'ES_Students';

    protected $primaryKey = 'StudentNo';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'SmartCardID'
    ];
}
