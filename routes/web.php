<?php

use App\Http\Controllers\RFIDEmployeeController;
use App\Http\Controllers\RFIDStudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleSlotsController;
use App\Http\Controllers\ScheduleRescheduleController;
use App\Http\Controllers\ScheduleCenterController;
use App\Http\Controllers\ScheduleDateController;
use App\Http\Controllers\ScheduleTimeController;
use App\Http\Controllers\ScheduleRoomController;
use App\Http\Controllers\ScheduleSessionController;
use App\Http\Controllers\CourseEvalController;
use App\Http\Controllers\CourseEvalParameterController;
use App\Http\Controllers\CourseEvalStatementController;
use App\Http\Controllers\CourseEvalRatingController;
use App\Http\Controllers\CourseEvalRemarkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;


Route::middleware(['auth', 'isActive', 'forcePassChange', 'securityHeaders'])->group(function () {

    Route::middleware(['isAdmin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('user/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');
        Route::resource('registers', RegistrationController ::class);
    });


    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::resource('admission/results', ResultController ::class);
    Route::get('admission/result/dashboard', [ResultController::class, 'index'])->name('results.index');
    Route::get('admission/result/overall', [ResultController::class, 'overall'])->name('results.overall');
    Route::get('admission/result/qualified', [ResultController::class, 'qualified'])->name('results.qualified');
    Route::get('admission/result/notQualified', [ResultController::class, 'notQualified'])->name('results.notQualified');
    Route::get('admission/result/transferees', [ResultController::class, 'transferees'])->name('results.transferees');

    Route::resource('admission/schedule/scheduleReschedules', ScheduleRescheduleController ::class);
    Route::get('admission/schedule/scheduleApplicants', [ScheduleController::class, 'scheduleApplicants'])->name('schedules.applicants');
    Route::get('admission/schedule/scheduleManagements', [ScheduleController::class, 'scheduleManagement'])->name('schedules.management');
    Route::resource('admission/schedule/scheduleSlots', ScheduleSlotsController ::class);
    Route::resource('admission/schedule/scheduleCenters', ScheduleCenterController ::class);
    Route::resource('admission/schedule/scheduleDates', ScheduleDateController ::class);
    Route::resource('admission/schedule/scheduleTimes', ScheduleTimeController ::class);
    Route::resource('admission/schedule/scheduleRooms', ScheduleRoomController ::class);
    Route::resource('admission/schedule/scheduleSessions', ScheduleSessionController ::class);


    // //EXPORT
    Route::post('/admission/results/exportApplicantsResults', [ResultController::class, 'exportApplicantsResults'])->name('export.applicantsResults');
    Route::post('/admission/schedule/exportApplicantsScheds', [ScheduleController::class, 'exportApplicantsScheds'])->name('export.applicantsSchedules');
    Route::post('/admission/schedule/exportSchedulesSlots', [ScheduleSlotsController::class, 'exportSchedulesSlots'])->name('export.schedulesSlots');

    //PDF
    Route::get('registration/pdf/USePAT', [PDFController::class, 'USePATForm'])->name('registrations.pdf.USePAT');
    Route::get('registration/pdf/USePATv2', [PDFController::class, 'USePATFormv2'])->name('registrations.pdf.USePATv2');



    Route::get('/rfid/dashboard', function () {
        return view('RFIDs.Dashboard');
    })->name('rfid.dashboard');

    Route::resource('rfid/studentsRFIDs', RFIDStudentController::class)->where(['studentsRFIDs' => '[a-zA-Z0-9_]+']);
    Route::resource('rfid/employeesRFIDs', RFIDEmployeeController::class)->where(['employeesRFIDs' => '[a-zA-Z0-9_]+']);


    Route::resource('courseEvals', CourseEvalController::class);
    Route::resource('courseEvalParameters', CourseEvalParameterController::class);
    Route::resource('courseEvalStatements', CourseEvalStatementController::class);
    Route::resource('courseEvalRatings', CourseEvalRatingController::class);
    Route::resource('courseEvalRemarks', CourseEvalRemarkController::class);


});







require __DIR__.'/auth.php';
require __DIR__.'/api.php';
require __DIR__.'/error.php';
