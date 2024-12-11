<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    // use HasFactory;
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionQualifiedApplicantsOfficial';

    protected $primaryKey = 'AppNO';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
}
