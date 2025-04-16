<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleSlotsController;
use App\Http\Controllers\ScheduleRescheduleController;
use App\Http\Controllers\RFIDEmployeeController;
use App\Http\Controllers\RFIDStudentController;
use App\Http\Controllers\RFIDController;


    //API ,'verifySession'
    Route::middleware(['auth', 'securityHeaders'])->group(function () {

        //ADMISSION API
        Route::get('/api/registrationsData', [RegistrationController::class, 'fetchData']);

        Route::get('/api/admission/result/overall', [ResultController::class, 'getOverallData'])->name('api.results.overall');
        Route::get('/api/admission/result/qualified', [ResultController::class, 'getQualifiedData'])->name('api.results.qualified');
        Route::get('/api/admission/result/notQualified', [ResultController::class, 'getNotQualifiedData'])->name('api.results.notQualified');
        Route::get('/api/admission/result/transferees', [ResultController::class, 'getTransfereeData'])->name('api.results.transferees');
        Route::get('/api/admission/result/dashboard', [ResultController::class, 'getDashboard'])->name('api.results.dashboard');
        Route::get('/api/admission/result/getColleges', [ResultController::class, 'getColleges']);
        Route::get('/api/admission/result/getPrograms', [ResultController::class, 'getPrograms']);
        Route::get('/api/admission/result/getMajors', [ResultController::class, 'getMajors']);
        Route::get('/api/admission/result/getEnlistedLogs', [ResultController::class, 'getEnlistedLogs'])->name('api.results.enlistedLogs');

        Route::get('/api/admission/schedule/applicants', [ScheduleController::class, 'getData'])->name('api.schedulesApplicants.data');
        Route::get('/api/admission/schedule/applicants/getDates', [ScheduleController::class, 'getDates']);
        Route::get('/api/admission/schedule/applicants/getRooms', [ScheduleController::class, 'getRooms']);
        Route::get('/api/admission/schedule/slots', [ScheduleSlotsController::class, 'getData'])->name('api.schedulesSlots.data');

        Route::get('/api/admission/schedule/reschedule/applicantSchedules', [ScheduleRescheduleController::class, 'getData'])->name('api.applicantSchedules.data');
        Route::get('/api/admission/schedule/reschedule/getAvailableScheds', [ScheduleRescheduleController::class, 'getAvailableScheds']);
        Route::get('/api/admission/schedule/reschedule/selectSchedDetails', [ScheduleRescheduleController::class, 'selectSchedDetails']);



        //RFID API
        Route::get('/api/rfid/data', [RFIDController::class, 'getData'])->name('api.rfids.data');
        Route::get('/api/rfid/genderStudent', [RFIDController::class, 'getStudentGender'])->name('api.rfids.genderStudent');
        Route::get('/api/rfid/genderEmployee', [RFIDController::class, 'getEmployeeGender'])->name('api.rfids.genderEmployee');
        Route::get('/api/rfid/employees', [RFIDEmployeeController::class, 'getData'])->name('api.rfidEmployees.data');
        Route::get('/api/rfid/students', [RFIDStudentController::class, 'getData'])->name('api.rfidStudents.data');

    });


    // Route::middleware(['auth:sanctum'])->group(function () {
    //     Route::get('/admission/result/getColleges', [ResultController::class, 'getColleges']);
    // });


?>
