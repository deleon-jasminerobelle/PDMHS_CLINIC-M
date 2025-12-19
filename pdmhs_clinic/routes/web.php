<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\HealthIncidentController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\VitalController;
use App\Http\Controllers\HealthFormController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('clinic-visits', ClinicVisitController::class);
    Route::resource('health-incidents', HealthIncidentController::class);
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('vitals', VitalController::class);

    Route::get('/health-form', [HealthFormController::class, 'index'])->name('health-form.index');
    Route::post('/health-form', [HealthFormController::class, 'store'])->name('health-form.store');

    Route::get('/feature', function () {
        return view('feature');
    })->name('features');

    Route::get('/scanner', function () {
        return view('scanner');
    })->name('scanner');

    Route::get('/architecture', function () {
        return view('architecture');
    })->name('architecture');

    Route::get('/student-health-form', function () {
        return view('student-health-form');
    })->name('student-health-form');

    Route::middleware(['check.health.form'])->group(function () {
        Route::get('/student-dashboard', [HealthFormController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/student-profile/edit', [HealthFormController::class, 'edit'])->name('student.profile.edit');
        Route::put('/student-profile', [HealthFormController::class, 'update'])->name('student.profile.update');
    });
});
