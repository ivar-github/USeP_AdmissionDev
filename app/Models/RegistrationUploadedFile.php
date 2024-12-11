<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationUploadedFile extends Model
{
    
    protected $connection = 'sqlsrv2'; 
    protected $table = 'CUSTOM_AdmissionRequiredDocsSubmission';

    public $timestamps = false;

}
