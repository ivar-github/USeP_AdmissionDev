<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseEvalController;
use App\Http\Controllers\CourseEvalParameterController;
use App\Http\Controllers\CourseEvalStatementController;
use App\Http\Controllers\CourseEvalRatingController;
use App\Http\Controllers\CourseEvalRemarkController;
use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Exports\ResultsExport;
use App\Http\Controllers\ScheduleRescheduleController;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware(['auth', CheckUserStatus::class])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/rfid/dashboard', function () {
        return view('RFIDs.Dashboard');
    })->name('rfid.dashboard');

    Route::resource('rfid/studentsRFIDs', StudentController::class);
    // Route::resource('rfid/employeesRFIDs', EmployeeController::class);
    // Route::resource('rfid/employeesRFIDs', EmployeeController::class)->where(['employeesRFIDs' => '.*']);
    Route::resource('rfid/employeesRFIDs', EmployeeController::class)
    ->where(['employeesRFIDs' => '[a-zA-Z0-9_]+']);

    // Route::post('rfid/employee/search', [EmployeeController::class, 'search'])->name('employeesRFIDs.search');
    Route::get('rfid/employee/search', [EmployeeController::class, 'indexb'])->name('employeesRFIDs.search');
    Route::get('rfid/employee/table', [EmployeeController::class, 'table'])->name('employeesRFIDs.table');
    Route::get('rfid/student/table', [StudentController::class, 'table'])->name('students.table');
    Route::post('rfid/student/search', [StudentController::class, 'search'])->name('students.search');

    Route::resource('users', UserController::class);
    Route::patch('user/resetPassword', [UserController::class, 'resetPassword'])->name('users.resetPassword');

    // Route::resource('questions', QuestionController::class);
    // Route::resource('datas', DataController::class);
    Route::resource('registers', RegistrationController ::class);

    // Route::resource('admission/results', ResultController ::class);
    Route::get('admission/result/dashboard', [ResultController::class, 'index'])->name('results.index');
    Route::get('admission/result/applicants', [ResultController::class, 'applicants'])->name('results.applicants');

    // Route::resource('schedules', ResultController ::class);
    Route::get('admission/schedule/scheduleApplicants', [ScheduleController::class, 'scheduleApplicants'])->name('schedules.applicants');
    Route::resource('admission/schedule/scheduleReschedules', ScheduleRescheduleController ::class);
    Route::post('admission/schedule/reschedules/search', [ScheduleRescheduleController::class, 'search'])->name('scheduleReschedules.search');

    Route::resource('courseEvals', CourseEvalController::class);
    Route::resource('courseEvalParameters', CourseEvalParameterController::class);
    Route::resource('courseEvalStatements', CourseEvalStatementController::class);
    Route::resource('courseEvalRatings', CourseEvalRatingController::class);
    Route::resource('courseEvalRemarks', CourseEvalRemarkController::class);


    //API
    // Route::get('/api/data', [DataController::class, 'fetchData']);
    Route::get('/api/registrationsData', [RegistrationController::class, 'fetchData']);

    Route::get('/api/rfid/data', [RFIDController::class, 'getData'])->name('api.rfids.data');
    Route::get('/api/rfid/genderStudent', [RFIDController::class, 'getStudentGender'])->name('api.rfids.genderStudent');
    Route::get('/api/rfid/genderEmployee', [RFIDController::class, 'getEmployeeGender'])->name('api.rfids.genderEmployee');

    Route::get('/api/admission/result/applicants', [ResultController::class, 'getData'])->name('api.results.data');
    Route::get('/api/admission/result/getPrograms', [ResultController::class, 'getPrograms']);
    Route::get('/api/admission/result/getMajors', [ResultController::class, 'getMajors']);

    Route::get('/api/admission/schedule/applicants', [ScheduleController::class, 'getData'])->name('api.schedulesApplicants.data');
    Route::get('/api/admission/schedule/applicants/getDates', [ScheduleController::class, 'getDates']);
    Route::get('/api/admission/schedule/applicants/getTimes', [ScheduleController::class, 'getTimes']);

    Route::get('/api/rfid/employees', [EmployeeController::class, 'getData'])->name('api.rfidEmployees.data');

    Route::get('/api/admission/schedule/reschedule/getAvailableScheds', [ScheduleRescheduleController::class, 'getAvailableScheds']);
    Route::get('/api/admission/schedule/reschedule/selectSchedDetails', [ScheduleRescheduleController::class, 'selectSchedDetails']);


    //EXPORT
    // Route::get('/export-users', [UserController::class, 'exportUsers'])->name('export.users');
    Route::post('/admission/results/exportApplicantsResults', [ResultController::class, 'exportApplicantsResults'])->name('export.applicantsResults');
    Route::post('/admission/schedule/exportApplicantsScheds', [ScheduleController::class, 'exportApplicantsScheds'])->name('export.applicantsSchedules');


    // MODAL
    // Route::get('modal/index', [ModalController::class, 'index'])->name('modal.index');
    // Route::get('modal/create', [ModalController::class, 'create'])->name('modal.create');


    //PDF
    Route::get('registration/pdf/USePAT', [PDFController::class, 'USePATForm'])->name('registrations.pdf.USePAT');
    Route::get('registration/pdf/USePATv2', [PDFController::class, 'USePATFormv2'])->name('registrations.pdf.USePATv2');
});







require __DIR__.'/auth.php';
