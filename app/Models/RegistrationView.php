<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationView extends Model
{

    protected $connection = 'sqlsrv2'; 
    protected $table = 'vw_AdmissionOverallApplicantCHEDv2';

    public $timestamps = false;


}
