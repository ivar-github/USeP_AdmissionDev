<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'HR_Employees';

    protected $primaryKey = 'EmployeeID';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'SmartCardID'
    ];

    //TO ALLOW ID AS STRING
    public function getRouteKeyName()
    {
        return 'EmployeeID';
    }

}
