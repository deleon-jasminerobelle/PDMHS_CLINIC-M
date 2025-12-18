<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\HealthIncidentController;
use App\Http\Controllers\VitalController;

Route::get('/', function () {
    return view('welcome');
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

Route::get('/student-health-form', function () {
    return view('student-health-form');
})->name('student-health-form');

Route::resource('students', StudentController::class);
Route::resource('clinic-visits', ClinicVisitController::class)->parameters(['clinic-visits' => 'clinicVisit']);
Route::resource('immunizations', ImmunizationController::class);
Route::resource('health-incidents', HealthIncidentController::class)->parameters(['health-incidents' => 'healthIncident']);
Route::resource('vitals', VitalController::class);
