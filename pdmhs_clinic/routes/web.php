<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClinicVisitController;
use App\Http\Controllers\HealthIncidentController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\VitalController;
use App\Http\Controllers\HealthFormController;
use App\Http\Controllers\ReportsController;
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
Route::match(['GET', 'POST'], '/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [LoginController::class, 'register'])->name('register.post');

Route::get('/feature', function () {
    return view('feature');
})->name('features');

// Main dashboard route (redirects based on role)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| Role-based Dashboard Routes
|--------------------------------------------------------------------------
*/

// Student routes - using auth middleware only (role check is in controller)
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])
        ->name('dashboard');
    Route::get('/medical', [DashboardController::class, 'studentMedical'])->name('medical');
    Route::get('/medical-history', [DashboardController::class, 'studentMedicalHistory'])->name('medical-history');
    Route::get('/info', [DashboardController::class, 'studentInfo'])->name('info');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [DashboardController::class, 'updatePassword'])->name('password.update');
    Route::post('/upload-profile-picture', [DashboardController::class, 'uploadProfilePicture'])->name('upload-profile-picture');
});

// Adviser routes - using auth middleware only (role check is in controller)
Route::middleware(['auth'])->prefix('adviser')->name('adviser.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adviserDashboard'])->name('dashboard');
});

// Clinic Staff routes - using auth middleware only (role check is in controller)
Route::middleware(['auth'])->prefix('clinic-staff')->name('clinic-staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'clinicStaffDashboard'])->name('dashboard');
    Route::get('/students', [DashboardController::class, 'clinicStaffStudents'])->name('students');
    Route::get('/students/{id}', [DashboardController::class, 'clinicStaffStudentProfile'])->name('student.profile');
    Route::post('/students/{id}/visit', [DashboardController::class, 'addStudentVisit'])->name('student.visit');
    Route::get('/visits', [DashboardController::class, 'clinicStaffVisits'])->name('visits');
    Route::get('/visits/{visitId}/details', [DashboardController::class, 'getVisitDetails'])->name('visit.details');
    Route::post('/visits', [DashboardController::class, 'storeVisit'])->name('visits.store');
    Route::get('/students/search', [DashboardController::class, 'searchStudents'])->name('students.search');
    Route::get('/reports', [\App\Http\Controllers\ReportsController::class, 'index'])->name('reports');
    Route::post('/reports/export-pdf', [\App\Http\Controllers\ReportsController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::post('/reports/export-excel', [\App\Http\Controllers\ReportsController::class, 'exportExcel'])->name('reports.export-excel');
    Route::get('/profile', [DashboardController::class, 'clinicStaffProfile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateClinicStaffProfile'])->name('profile.update');
    Route::put('/password', [DashboardController::class, 'updateClinicStaffPassword'])->name('password.update');
    Route::post('/upload-profile-picture', [DashboardController::class, 'uploadClinicStaffProfilePicture'])->name('upload-profile-picture');
});

/*
|--------------------------------------------------------------------------
| Admin/Staff Management Routes
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

    // Student health form routes (moved from public to protected)
    Route::get('/student-health-form', function () {
        return view('student-health-form');
    })->name('student-health-form');

    Route::post('/student-health-form', [HealthFormController::class, 'store'])->name('student.health.store');

    Route::get('/scanner', function () {
        return view('scanner');
    })->name('scanner');

    Route::get('/architecture', function () {
        return view('architecture');
    })->name('architecture');
});

/*
|--------------------------------------------------------------------------
| Utility Routes
|--------------------------------------------------------------------------
*/

// CSRF token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('auth');

// Keep alive route
Route::post('/keep-alive', function () {
    if (!Auth::check()) {
        return response()->json(['status' => 'unauthenticated'], 401);
    }
    return response()->json([
        'status' => 'alive',
        'user' => ['id' => Auth::user()->id, 'name' => Auth::user()->name, 'role' => Auth::user()->role],
        'timestamp' => now()->toISOString()
    ]);
})->middleware('auth');

// Session status check route
Route::get('/session-status', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::check() ? ['id' => Auth::user()->id, 'name' => Auth::user()->name, 'email' => Auth::user()->email, 'role' => Auth::user()->role] : null,
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'timestamp' => now()->toISOString()
    ]);
});

/*
|--------------------------------------------------------------------------
| Test Routes (Remove in production)
|--------------------------------------------------------------------------
*/

// Create test users
Route::get('/create-test-users', function () {
    try {
        // Create student user
        $student = \App\Models\User::updateOrCreate(
            ['email' => 'student@pdmhs.edu.ph'],
            [
                'name' => 'Hannah Loraine Geronday',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        // Create clinic staff user
        $clinicStaff = \App\Models\User::updateOrCreate(
            ['email' => 'nurse@pdmhs.edu.ph'],
            [
                'name' => 'Maria Santos',
                'password' => Hash::make('nurse123'),
                'role' => 'clinic_staff',
                'email_verified_at' => now(),
            ]
        );

        // Create adviser user
        $adviser = \App\Models\User::updateOrCreate(
            ['email' => 'adviser@pdmhs.edu.ph'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('adviser123'),
                'role' => 'adviser',
                'email_verified_at' => now(),
            ]
        );
        
        return response()->json([
            'message' => 'Test users created successfully!',
            'users' => [
                'student' => ['email' => 'student@pdmhs.edu.ph', 'password' => 'student123'],
                'clinic_staff' => ['email' => 'nurse@pdmhs.edu.ph', 'password' => 'nurse123'],
                'adviser' => ['email' => 'adviser@pdmhs.edu.ph', 'password' => 'adviser123']
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Debug routes
Route::get('/debug-auth', function () {
    $user = Auth::user();
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => $user ? $user->toArray() : 'Not logged in',
        'role' => $user ? $user->role : 'No role',
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'routes' => [
            'student_dashboard' => route('student.dashboard'),
            'clinic_staff_dashboard' => route('clinic-staff.dashboard'),
            'adviser_dashboard' => route('adviser.dashboard'),
        ]
    ]);
})->middleware('auth');



// Test profile update route
Route::post('/test-profile-update', function (Request $request) {
    $user = Auth::user();
    Log::info('Test profile update', [
        'user' => $user ? $user->toArray() : null,
        'request_data' => $request->all(),
        'method' => $request->method()
    ]);
    
    return response()->json([
        'success' => true,
        'user' => $user ? $user->toArray() : null,
        'request_data' => $request->all()
    ]);
})->middleware('auth');

// Session debug route (no auth required)
Route::get('/debug-session', function () {
    return response()->json([
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'authenticated' => Auth::check(),
        'user_id' => Auth::check() ? Auth::id() : null,
        'config' => [
            'session_driver' => config('session.driver'),
            'session_lifetime' => config('session.lifetime'),
            'session_expire_on_close' => config('session.expire_on_close'),
        ]
    ]);
});

// Test dashboard access
Route::get('/test-dashboards', function () {
    if (!Auth::check()) {
        return 'Please login first: <a href="' . route('login') . '">Login</a>';
    }
    
    $user = Auth::user();
    $html = "<h2>Dashboard Test for: {$user->name} ({$user->role})</h2>";
    $html .= "<p><a href='" . route('student.dashboard') . "'>Student Dashboard</a></p>";
    $html .= "<p><a href='" . route('clinic-staff.dashboard') . "'>Clinic Staff Dashboard</a></p>";
    $html .= "<p><a href='" . route('adviser.dashboard') . "'>Adviser Dashboard</a></p>";
    $html .= "<p><a href='" . route('logout') . "' onclick='event.preventDefault(); document.getElementById(\"logout-form\").submit();'>Logout</a></p>";
    $html .= '<form id="logout-form" action="' . route('logout') . '" method="POST" style="display: none;">' . csrf_field() . '</form>';
    
    return $html;
})->middleware('auth');