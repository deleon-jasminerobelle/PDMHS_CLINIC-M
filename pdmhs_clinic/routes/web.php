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

// Session status check route
Route::get('/session-status', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email', 'role']) : null,
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token()
    ]);
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

Route::post('/student-health-form', [HealthFormController::class, 'submitForm'])->name('student.health.store');

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
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
    Route::get('/medical', [DashboardController::class, 'studentMedical'])->name('medical');
    Route::get('/medical-history', [DashboardController::class, 'studentMedicalHistory'])->name('medical-history');
    Route::get('/info', [DashboardController::class, 'studentInfo'])->name('info');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [DashboardController::class, 'updatePassword'])->name('password.update');
    Route::post('/upload-profile-picture', [DashboardController::class, 'uploadProfilePicture'])->name('upload-profile-picture');
});

// Adviser routes
Route::middleware(['auth'])->prefix('adviser')->name('adviser.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adviserDashboard'])->name('dashboard');
});

// Clinic Staff routes
Route::middleware(['auth'])->prefix('clinic-staff')->name('clinic-staff.')->group(function () {
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
        'user' => $user ? $user->toArray() : 'Not logged in',
        'role' => $user ? $user->role : 'No role',
        'isStudent' => $user ? $user->isStudent() : false,
        'isClinicStaff' => $user ? $user->isClinicStaff() : false,
        'isAdviser' => $user ? $user->isAdviser() : false,
        'expected_routes' => [
            'student' => route('student.dashboard'),
            'adviser' => route('adviser.dashboard'),
            'clinic_staff' => route('clinic-staff.dashboard'),
        ]
    ]);
})->middleware('auth');

// Test routes for debugging dashboard access
Route::get('/test-student', function () {
    if (!Auth::check()) {
        return 'Not authenticated';
    }
    $user = Auth::user();
    return "User: {$user->name}, Role: {$user->role}, Is Student: " . ($user->isStudent() ? 'Yes' : 'No');
})->middleware('auth');

Route::get('/test-adviser', function () {
    if (!Auth::check()) {
        return 'Not authenticated';
    }
    $user = Auth::user();
    return "User: {$user->name}, Role: {$user->role}, Is Adviser: " . ($user->isAdviser() ? 'Yes' : 'No');
})->middleware('auth');

Route::get('/test-clinic-staff', function () {
    if (!Auth::check()) {
        return 'Not authenticated';
    }
    $user = Auth::user();
    return "User: {$user->name}, Role: {$user->role}, Is Clinic Staff: " . ($user->isClinicStaff() ? 'Yes' : 'No');
})->middleware('auth');

// Direct dashboard test routes (bypass middleware for testing)
Route::get('/direct-student-dashboard', [DashboardController::class, 'studentDashboard'])->middleware('auth');
Route::get('/direct-adviser-dashboard', [DashboardController::class, 'adviserDashboard'])->middleware('auth');
Route::get('/direct-clinic-staff-dashboard', [DashboardController::class, 'clinicStaffDashboard'])->middleware('auth');

// Simple test routes to check if controllers work
Route::get('/test-student-controller', function () {
    if (!Auth::check()) {
        return 'Not authenticated - please login first';
    }
    
    $user = Auth::user();
    
    try {
        $controller = new \App\Http\Controllers\DashboardController();
        $result = $controller->studentDashboard();
        return 'Student dashboard controller works! User: ' . $user->name . ' (' . $user->role . ')';
    } catch (\Exception $e) {
        return 'Error in student dashboard: ' . $e->getMessage();
    }
})->middleware('auth');

Route::get('/test-clinic-staff-controller', function () {
    if (!Auth::check()) {
        return 'Not authenticated - please login first';
    }
    
    $user = Auth::user();
    
    try {
        $controller = new \App\Http\Controllers\DashboardController();
        $result = $controller->clinicStaffDashboard();
        return 'Clinic staff dashboard controller works! User: ' . $user->name . ' (' . $user->role . ')';
    } catch (\Exception $e) {
        return 'Error in clinic staff dashboard: ' . $e->getMessage();
    }
})->middleware('auth');

// Test route for profile picture upload
Route::get('/test-upload', function () {
    return view('test-upload');
});

// Create clinic staff user for testing
Route::get('/create-clinic-staff', function () {
    try {
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'nurse@pdmhs.edu.ph'],
            [
                'name' => 'Maria Santos',
                'password' => \Hash::make('nurse123'),
                'role' => 'clinic_staff',
                'email_verified_at' => now(),
            ]
        );
        
        return "Clinic staff user created/updated successfully! Email: nurse@pdmhs.edu.ph, Password: nurse123, Role: " . $user->role;
    } catch (\Exception $e) {
        return "Error creating user: " . $e->getMessage();
    }
});

// Simple clinic staff dashboard test (bypass potential routing issues)
Route::get('/clinic-staff-test', function () {
    // Create a fake user object for testing
    $fakeUser = (object) [
        'id' => 1,
        'name' => 'Test Clinic Staff',
        'email' => 'nurse@pdmhs.edu.ph',
        'role' => 'clinic_staff'
    ];
    
    return view('clinic-staff-dashboard', ['user' => $fakeUser]);
});

// Simple student dashboard test (bypass potential routing issues)
Route::get('/student-test', function () {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please log in first');
    }
    
    $user = Auth::user();
    
    if ($user->role !== 'student') {
        return redirect()->route('login')->with('error', 'Access denied - student only');
    }
    
    // Use the same data structure as the controller
    $data = [
        'user' => $user,
        'student' => null,
        'lastVisit' => null,
        'latestVitals' => (object) ['weight' => 'N/A', 'height' => 'N/A'],
        'bmi' => 'N/A',
        'bmiCategory' => 'N/A',
        'allergies' => collect(),
        'immunizations' => collect(),
        'age' => 'N/A',
        'recentVisits' => collect(),
        'totalVisits' => 0
    ];
    
    return view('student-dashboard', $data);
})->middleware('auth');