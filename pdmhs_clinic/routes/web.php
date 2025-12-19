<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\HealthIncidentController;
use App\Http\Controllers\VitalController;
use App\Http\Controllers\HealthFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('student-health-form');
})->name('home');

Route::get('/features', function () {
    return view('feature');
})->name('features');

Route::get('/architecture', function () {
    return view('architecture');
})->name('architecture');

Route::get('/scanner', function () {
    return view('scanner');
})->name('scanner');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);

// Debug route
Route::get('/debug', function () {
    $user = \App\Models\User::where('email', 'student@pdmhs.edu.ph')->first();
    $student = \App\Models\Student::first();
    
    return response()->json([
        'user' => $user ? $user->toArray() : 'Not found',
        'student' => $student ? $student->toArray() : 'Not found',
        'students_count' => \App\Models\Student::count(),
        'users_count' => \App\Models\User::count()
    ]);
});

// Adviser routes
Route::middleware(['adviser'])->group(function () {
    Route::get('/adviser/dashboard', [DashboardController::class, 'index'])->name('adviser.dashboard');
});



Route::get('/student-health-form', function () {
    return view('student-health-form');
})->name('student-health-form');

Route::post('/student-health-form', [HealthFormController::class, 'submitForm'])->name('student.health.store');

Route::middleware(['admin.staff'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('clinic-visits', ClinicVisitController::class)->parameters(['clinic-visits' => 'clinicVisit']);
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('health-incidents', HealthIncidentController::class)->parameters(['health-incidents' => 'healthIncident']);
    Route::resource('vitals', VitalController::class);
});
