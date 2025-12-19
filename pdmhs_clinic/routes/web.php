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
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

<<<<<<< HEAD
Route::get('/register', function () {
    return view('register');
})->name('register');
=======
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
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee

Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

<<<<<<< HEAD
=======
Route::middleware(['admin.staff'])->group(function () {
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
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
