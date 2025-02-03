<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\ScheduleApplicantController;
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

    Route::resource('students', StudentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('users', UserController::class);
    // Route::resource('questions', QuestionController::class);
    // Route::resource('datas', DataController::class);
    Route::resource('registers', RegistrationController ::class);

    Route::resource('results', ResultController ::class);
    Route::get('result/data', [ResultController::class, 'data'])->name('results.data');

    Route::resource('schedules', ResultController ::class);
    Route::get('schedule/overall', [ScheduleController::class, 'overall'])->name('schedules.overall');
    Route::resource('scheduleApplicants', ScheduleApplicantController ::class);
    Route::post('scheduleApplicant/search', [ScheduleApplicantController::class, 'search'])->name('scheduleApplicants.search');




    Route::post('employee/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::get('employee/table', [EmployeeController::class, 'table'])->name('employees.table');
    Route::get('student/table', [StudentController::class, 'table'])->name('students.table');
    Route::post('student/search', [StudentController::class, 'search'])->name('students.search');

    Route::resource('courseEvals', CourseEvalController::class);
    Route::resource('courseEvalParameters', CourseEvalParameterController::class);
    Route::resource('courseEvalStatements', CourseEvalStatementController::class);
    Route::resource('courseEvalRatings', CourseEvalRatingController::class);
    Route::resource('courseEvalRemarks', CourseEvalRemarkController::class);


    //API
    Route::get('/api/data', [DataController::class, 'fetchData']);
    Route::get('/api/registrationsData', [RegistrationController::class, 'fetchData']);

    Route::get('/api/dashboard-data', [DashboardController::class, 'getData'])->name('api.dashboard.data');
    Route::get('/api/dashboard-genderStudent', [DashboardController::class, 'getStudentGender'])->name('api.dashboard.genderStudent');
    Route::get('/api/dashboard-genderEmployee', [DashboardController::class, 'getEmployeeGender'])->name('api.dashboard.genderEmployee');

    Route::get('/api/resultsData', [ResultController::class, 'getData'])->name('api.results.data');
    Route::get('/api/resultsData/getPrograms', [ResultController::class, 'getPrograms']);
    Route::get('/api/resultsData/getMajors', [ResultController::class, 'getMajors']);

    Route::get('/api/schedulesData', [ScheduleController::class, 'getData'])->name('api.schedules.data');
    Route::get('/api/schedulesData/getDates', [ScheduleController::class, 'getDates']);
    Route::get('/api/schedulesData/getTimes', [ScheduleController::class, 'getTimes']);

    // Route::get('/api/resultsData', [CourseEvalParameterController::class, 'getData'])->name('api.results.data');
    // Route::get('/api/parameterData/getDataByStatus', [CourseEvalParameterController::class, 'getDataByStatus']);
    // Route::get('/api/resultsData/getMajors', [CourseEvalParameterController::class, 'getMajors']);

    //EXPORT
    Route::get('/export-users', [UserController::class, 'exportUsers'])->name('export.users');
    Route::post('/results/export', [ResultController::class, 'exportResults'])->name('results.export');
    Route::post('/schedules/exportOverallScheds', [ScheduleController::class, 'exportOverallScheds'])->name('overallSchedules.export');


    // MODAL
    Route::get('modal/index', [ModalController::class, 'index'])->name('modal.index');
    Route::get('modal/create', [ModalController::class, 'create'])->name('modal.create');


    //PDF
    Route::get('registration/pdf/USePAT', [PDFController::class, 'USePATForm'])->name('registrations.pdf.USePAT');
    Route::get('registration/pdf/USePATv2', [PDFController::class, 'USePATFormv2'])->name('registrations.pdf.USePATv2');
});







require __DIR__.'/auth.php';
