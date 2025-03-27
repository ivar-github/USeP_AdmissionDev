<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultView extends Model
{
    // use HasFactory;
    protected $connection = 'sqlsrv2'; 
    protected $table = 'vw_QualifiedApplicantsOfficialDetails';
    // protected $table = 'vw_CUSTOM_AdmissionQualifiedApplicantsOfficial_TEST';

    // protected $primaryKey = 'AppNo';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        // 'MobileNo'
    ];
}
