<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\HealthIncidentController;
use App\Http\Controllers\VitalController;
use App\Http\Controllers\HealthFormController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/student-health-form', function () {
    return view('student-health-form');
})->name('student-health-form');

Route::post('/student-health-form', [HealthFormController::class, 'submitForm'])->name('student.health.store');

Route::middleware(['auth', 'check.health.form'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('clinic-visits', ClinicVisitController::class)->parameters(['clinic-visits' => 'clinicVisit']);
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('health-incidents', HealthIncidentController::class)->parameters(['health-incidents' => 'healthIncident']);
    Route::resource('vitals', VitalController::class);
});
