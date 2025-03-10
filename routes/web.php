<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Auth\RegisteredUserController;
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
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\CourseEvalController;
use App\Http\Controllers\CourseEvalParameterController;
use App\Http\Controllers\CourseEvalStatementController;
use App\Http\Controllers\CourseEvalRatingController;
use App\Http\Controllers\CourseEvalRemarkController;
use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

Route::middleware(['auth', CheckUserStatus::class])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class);
    Route::patch('user/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');


    Route::resource('registers', RegistrationController ::class);

    Route::get('admission/result/dashboard', [ResultController::class, 'index'])->name('results.index');
    Route::get('admission/result/applicants', [ResultController::class, 'applicants'])->name('results.applicants');

    Route::resource('admission/schedule/scheduleReschedules', ScheduleRescheduleController ::class);
    Route::get('admission/schedule/scheduleApplicants', [ScheduleController::class, 'scheduleApplicants'])->name('schedules.applicants');
    Route::get('admission/schedule/scheduleManagements', [ScheduleController::class, 'scheduleManagement'])->name('schedules.management');
    Route::resource('admission/schedule/scheduleSlots', ScheduleSlotsController ::class);
    Route::resource('admission/schedule/scheduleCenters', ScheduleCenterController ::class);
    Route::resource('admission/schedule/scheduleDates', ScheduleDateController ::class);
    Route::resource('admission/schedule/scheduleTimes', ScheduleTimeController ::class);
    Route::resource('admission/schedule/scheduleRooms', ScheduleRoomController ::class);
    Route::resource('admission/schedule/scheduleSessions', ScheduleSessionController ::class);


    //API
    Route::get('/api/registrationsData', [RegistrationController::class, 'fetchData']);

    Route::get('/api/admission/result/applicants', [ResultController::class, 'getData'])->name('api.results.data');
    Route::get('/api/admission/result/getColleges', [ResultController::class, 'getColleges']);
    Route::get('/api/admission/result/getPrograms', [ResultController::class, 'getPrograms']);
    Route::get('/api/admission/result/getMajors', [ResultController::class, 'getMajors']);

    Route::get('/api/admission/schedule/applicants', [ScheduleController::class, 'getData'])->name('api.schedulesApplicants.data');
    Route::get('/api/admission/schedule/applicants/getDates', [ScheduleController::class, 'getDates']);
    Route::get('/api/admission/schedule/applicants/getRooms', [ScheduleController::class, 'getRooms']);
    Route::get('/api/admission/schedule/slots', [ScheduleSlotsController::class, 'getData'])->name('api.schedulesSlots.data');

    Route::get('/api/admission/schedule/reschedule/applicantSchedules', [ScheduleRescheduleController::class, 'getData'])->name('api.applicantSchedules.data');
    Route::get('/api/admission/schedule/reschedule/getAvailableScheds', [ScheduleRescheduleController::class, 'getAvailableScheds']);
    Route::get('/api/admission/schedule/reschedule/selectSchedDetails', [ScheduleRescheduleController::class, 'selectSchedDetails']);

    //EXPORT
    Route::post('/admission/results/exportApplicantsResults', [ResultController::class, 'exportApplicantsResults'])->name('export.applicantsResults');
    Route::post('/admission/schedule/exportApplicantsScheds', [ScheduleController::class, 'exportApplicantsScheds'])->name('export.applicantsSchedules');
    Route::post('/admission/schedule/exportSchedulesSlots', [ScheduleSlotsController::class, 'exportSchedulesSlots'])->name('export.schedulesSlots');

    //PDF
    Route::get('registration/pdf/USePAT', [PDFController::class, 'USePATForm'])->name('registrations.pdf.USePAT');
    Route::get('registration/pdf/USePATv2', [PDFController::class, 'USePATFormv2'])->name('registrations.pdf.USePATv2');


    

    Route::get('/rfid/dashboard', function () {
        return view('RFIDs.Dashboard');
    })->name('rfid.dashboard');

    Route::resource('rfid/studentsRFIDs', RFIDStudentController::class)
    ->where(['employeesRFIDs' => '[a-zA-Z0-9_]+']);
    
    Route::resource('rfid/employeesRFIDs', RFIDEmployeeController::class)
    ->where(['employeesRFIDs' => '[a-zA-Z0-9_]+']);

    Route::get('/api/rfid/data', [RFIDController::class, 'getData'])->name('api.rfids.data');
    Route::get('/api/rfid/genderStudent', [RFIDController::class, 'getStudentGender'])->name('api.rfids.genderStudent');
    Route::get('/api/rfid/genderEmployee', [RFIDController::class, 'getEmployeeGender'])->name('api.rfids.genderEmployee');

    Route::get('/api/rfid/employees', [RFIDEmployeeController::class, 'getData'])->name('api.rfidEmployees.data');
    Route::get('/api/rfid/students', [RFIDStudentController::class, 'getData'])->name('api.rfidStudents.data');





    Route::resource('courseEvals', CourseEvalController::class);
    Route::resource('courseEvalParameters', CourseEvalParameterController::class);
    Route::resource('courseEvalStatements', CourseEvalStatementController::class);
    Route::resource('courseEvalRatings', CourseEvalRatingController::class);
    Route::resource('courseEvalRemarks', CourseEvalRemarkController::class);
});







require __DIR__.'/auth.php';
