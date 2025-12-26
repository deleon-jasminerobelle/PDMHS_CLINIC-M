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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// CSRF token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('auth');

// Keep alive route
Route::post('/keep-alive', function () {
    return response()->json(['status' => 'alive']);
})->middleware('auth');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::get('/feature', function () {
    return view('feature');
})->name('features');

Route::get('/student-health-form', function () {
    return view('student-health-form');
})->name('student-health-form');

Route::post('/student-health-form', [HealthFormController::class, 'store'])->name('student.health.store')->middleware('auth');

// Main dashboard route (redirects based on role)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Role-based Dashboard Routes
|--------------------------------------------------------------------------
*/

// Student routes
Route::middleware(['auth', 'student', 'check.health.form'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/qr-code', [DashboardController::class, 'generateQrCode'])->name('qr-code');
});

// Adviser routes
Route::middleware(['auth', 'adviser'])->prefix('adviser')->name('adviser.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adviserDashboard'])->name('dashboard');
    Route::get('/students/{student}', [DashboardController::class, 'showStudent'])->name('students.show');
    Route::get('/clinic-visits/{visit}', [DashboardController::class, 'showClinicVisit'])->name('clinic-visits.show');
});

// Clinic Staff routes
Route::middleware(['auth', 'clinic.staff'])->prefix('clinic-staff')->name('clinic-staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'clinicStaffDashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin/Staff Management Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin.staff'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('clinic-visits', ClinicVisitController::class);
    Route::resource('health-incidents', HealthIncidentController::class);
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('vitals', VitalController::class);

    Route::get('/health-form', [HealthFormController::class, 'index'])->name('health-form.index');
    Route::post('/health-form', [HealthFormController::class, 'store'])->name('health-form.store');
    Route::put('/health-form/{id}', [HealthFormController::class, 'update'])->name('health-form.update');

    Route::get('/scanner', function () {
        return view('scanner');
    })->name('scanner');

    Route::get('/architecture', function () {
        return view('architecture');
    })->name('architecture');
});

/*
|--------------------------------------------------------------------------
| Debug Routes (Remove in production)
|--------------------------------------------------------------------------
*/

Route::get('/debug', function () {
    $user = \App\Models\User::where('email', 'student@pdmhs.edu.ph')->first();
    $student = \App\Models\Student::first();
    
    return response()->json([
        'user' => $user ? $user->toArray() : 'Not found',
        'user_role' => $user ? $user->role : 'No role',
        'should_see_dashboard' => $user ? ($user->role === 'student' ? 'student-dashboard' : ($user->role === 'adviser' ? 'adviser-dashboard' : 'dashboard')) : 'unknown',
        'student' => $student ? $student->toArray() : 'Not found',
        'students_count' => \App\Models\Student::count(),
        'users_count' => \App\Models\User::count()
    ]);
});

Route::get('/auth-debug', function () {
    $user = Auth::user();
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => ($user instanceof \App\Models\User) ? $user->toArray() : 'Not logged in',
        'role' => ($user instanceof \App\Models\User) ? $user->role : 'No role',
        'isStudent' => ($user instanceof \App\Models\User) ? $user->isStudent() : false,
        'isClinicStaff' => ($user instanceof \App\Models\User) ? $user->isClinicStaff() : false,
    ]);
})->middleware('auth');
