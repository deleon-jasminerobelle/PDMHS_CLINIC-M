<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\ClinicStaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\HealthIncidentController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\VitalController;
use App\Http\Controllers\HealthFormController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\CheckHealthForm; // <-- directly use middleware class

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::match(['GET', 'POST'], '/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::get('/feature', fn() => view('feature'))->name('features');

/*
|--------------------------------------------------------------------------
| Student Routes (protected by CheckHealthForm middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'student', 'check.health.form'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/medical', [StudentDashboardController::class, 'medical'])->name('medical');
        Route::get('/medical-history', [StudentDashboardController::class, 'medicalHistory'])->name('medical-history');
        Route::get('/info', [StudentDashboardController::class, 'info'])->name('info');
        Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [StudentDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [StudentDashboardController::class, 'updatePassword'])->name('password.update');
        Route::post('/upload-profile-picture', [StudentDashboardController::class, 'uploadProfilePicture'])->name('upload-profile-picture');
        Route::get('/allergies', [StudentDashboardController::class, 'getAllergies'])->name('allergies');
        Route::post('/allergies', [StudentDashboardController::class, 'updateAllergies'])->name('allergies.update');
    });

/*
|--------------------------------------------------------------------------
| Health Form Routes (excluded from CheckHealthForm to prevent redirect loop / HTTP 500)
|--------------------------------------------------------------------------
*/
Route::get('/student/health-form', [HealthFormController::class, 'index'])
    ->name('student-health-form');

Route::post('/student/health-form', [HealthFormController::class, 'store'])
    ->name('student.health.store');

/*
|--------------------------------------------------------------------------
| Adviser Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'adviser'])
    ->prefix('adviser')
    ->name('adviser.')
    ->group(function () {
        Route::get('/dashboard', [AdviserController::class, 'adviserDashboard'])->name('dashboard');
        Route::get('/profile', [AdviserController::class, 'adviserProfile'])->name('profile');
        Route::put('/profile', [AdviserController::class, 'updateAdviserProfile'])->name('profile.update');
        Route::put('/password', [AdviserController::class, 'updateAdviserPassword'])->name('password.update');
        Route::post('/upload-profile-picture', [AdviserController::class, 'uploadAdviserProfilePicture'])->name('upload-profile-picture');
    });

/*
|--------------------------------------------------------------------------
| Clinic Staff Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'clinic_staff'])
    ->prefix('clinic-staff')
    ->name('clinic-staff.')
    ->group(function () {
        Route::get('/dashboard', [ClinicStaffController::class, 'clinicDashboard'])->name('dashboard');
        Route::get('/students', [ClinicStaffController::class, 'clinicStudents'])->name('students');
        Route::get('/students/{id}', [ClinicStaffController::class, 'studentProfile'])->name('student-profile');
        Route::post('/students/{id}/visit', [ClinicStaffController::class, 'addStudentVisit'])->name('student-visit');
        Route::get('/visits', [ClinicStaffController::class, 'clinicVisits'])->name('visits');
        Route::get('/visits/{visitId}/details', [ClinicStaffController::class, 'getVisitDetails'])->name('visit-details');
        Route::post('/visits', [ClinicStaffController::class, 'storeVisit'])->name('visits-store');
        Route::post('/qr-process', [ClinicStaffController::class, 'processQR'])->name('qr-process');
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
        Route::post('/reports/export-pdf', [ReportsController::class, 'exportPdf'])->name('reports-export-pdf');
        Route::post('/reports/export-excel', [ReportsController::class, 'exportExcel'])->name('reports-export-excel');
        Route::get('/profile', [ClinicStaffController::class, 'profile'])->name('profile');
        Route::put('/profile', [ClinicStaffController::class, 'updateProfile'])->name('profile-update');
        Route::put('/password', [ClinicStaffController::class, 'updatePassword'])->name('password-update');
        Route::post('/upload-profile-picture', [ClinicStaffController::class, 'uploadProfilePicture'])->name('upload-profile-picture');
    });

/*
|--------------------------------------------------------------------------
| Admin / Staff Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('clinic-visits', ClinicVisitController::class);
    Route::resource('health-incidents', HealthIncidentController::class);
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('vitals', VitalController::class);

    Route::get('/health-form', [HealthFormController::class, 'index'])->name('health-form.index');
    Route::post('/health-form', [HealthFormController::class, 'store'])->name('health-form.store');

    Route::get('/scanner', fn() => view('scanner'))->name('scanner');
});

/*
|--------------------------------------------------------------------------
| Utility Routes
|--------------------------------------------------------------------------
*/
Route::get('/csrf-token', fn() => response()->json(['csrf_token'=>csrf_token()]))->middleware('auth');
Route::post('/keep-alive', fn() => Auth::check() ? response()->json([
    'status'=>'alive',
    'user'=>Auth::user(),
    'timestamp'=>now()->toISOString()
]) : response()->json(['status'=>'unauthenticated'],401))->middleware('auth');
Route::get('/session-status', fn() => response()->json([
    'authenticated'=>Auth::check(),
    'user'=>Auth::user(),
    'session_id'=>session()->getId(),
    'csrf_token'=>csrf_token(),
    'timestamp'=>now()->toISOString()
]));

/*
|--------------------------------------------------------------------------
| Test Routes (Remove in production)
|--------------------------------------------------------------------------
*/
// Removed test user creation route as per user request
