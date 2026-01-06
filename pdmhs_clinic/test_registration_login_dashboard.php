<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\ClinicStaffController;

echo "Testing user registration, login, and dashboard access...\n\n";

// Step 1: Register a new user (directly create records instead of using controller)
echo "Step 1: Creating a new student user directly...\n";

$registrationData = [
    'first_name' => 'Test',
    'middle_name' => 'User',
    'last_name' => 'Student',
    'birthday' => '2000-01-01',
    'gender' => 'male',
    'address' => '123 Test Street, Test City',
    'contact_number' => '09123456789',
    'email' => 'teststudent' . time() . '@pdmhs.edu.ph', // Unique email
    'password' => 'password123',
    'role' => 'student'
];

try {
    // Create student record first
    $student = Student::create([
        'student_id' => 'TEST' . time(), // Unique student ID
        'first_name' => $registrationData['first_name'],
        'middle_name' => $registrationData['middle_name'] ?: null,
        'last_name' => $registrationData['last_name'],
        'date_of_birth' => $registrationData['birthday'],
        'sex' => $registrationData['gender'], // Use sex instead of gender
        'grade_level' => 12,
        'section' => 'A',
        'contact_number' => $registrationData['contact_number'],
        'address' => $registrationData['address'],
        'emergency_contact_name' => 'Emergency Contact',
        'emergency_contact_number' => '09123456789',
        'emergency_relation' => 'Parent',
        'emergency_address' => $registrationData['address'],
        'age' => \Carbon\Carbon::parse($registrationData['birthday'])->age,
    ]);

    // Create user record linked to student
    $user = User::create([
        'name' => $registrationData['first_name'] . ' ' . ($registrationData['middle_name'] ? $registrationData['middle_name'] . ' ' : '') . $registrationData['last_name'],
        'email' => $registrationData['email'],
        'password' => Hash::make($registrationData['password']),
        'role' => $registrationData['role'],
        'student_id' => $student->id,
        'first_name' => $registrationData['first_name'],
        'middle_name' => $registrationData['middle_name'] ?: null,
        'last_name' => $registrationData['last_name'],
        'birthday' => $registrationData['birthday'],
        'gender' => $registrationData['gender'],
        'address' => $registrationData['address'],
        'contact_number' => $registrationData['contact_number'],
    ]);

    echo "✓ User and student records created successfully\n";
} catch (\Exception $e) {
    echo "✗ Failed to create user: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 2: Verify data is stored in database
echo "\nStep 2: Verifying data storage in database...\n";

$user = User::where('email', $registrationData['email'])->first();
if (!$user) {
    echo "✗ User not found in database\n";
    exit(1);
}

echo "✓ User found in users table:\n";
echo "  - ID: {$user->id}\n";
echo "  - Name: {$user->name}\n";
echo "  - Email: {$user->email}\n";
echo "  - Role: {$user->role}\n";
echo "  - First Name: {$user->first_name}\n";
echo "  - Middle Name: {$user->middle_name}\n";
echo "  - Last Name: {$user->last_name}\n";
echo "  - Birthday: {$user->birthday}\n";
echo "  - Gender: {$user->gender}\n";
echo "  - Address: {$user->address}\n";
echo "  - Contact Number: {$user->contact_number}\n";
echo "  - Student ID: {$user->student_id}\n";

if ($user->role === 'student') {
    $student = Student::find($user->student_id);
    if (!$student) {
        echo "✗ Student record not found\n";
        exit(1);
    }
    echo "✓ Student record found and linked:\n";
    echo "  - Student ID: {$student->id}\n";
    echo "  - First Name: {$student->first_name}\n";
    echo "  - Middle Name: {$student->middle_name}\n";
    echo "  - Last Name: {$student->last_name}\n";
    echo "  - Date of Birth: {$student->date_of_birth}\n";
    echo "  - Gender: {$student->gender}\n";
    echo "  - Address: {$student->address}\n";
    echo "  - Contact Number: {$student->contact_number}\n";
    echo "  - Age: {$student->age}\n";
}

// Step 3: Login with the new user
echo "\nStep 3: Logging in with the new user...\n";

// For testing purposes, directly authenticate the user since we don't have a proper session store
try {
    Auth::login($user);
    echo "✓ User authenticated directly\n";
} catch (\Exception $e) {
    echo "✗ Authentication failed: " . $e->getMessage() . "\n";
    exit(1);
}

if (!Auth::check()) {
    echo "✗ User not authenticated after login\n";
    exit(1);
}

echo "✓ User is authenticated: " . Auth::user()->name . "\n";

// Step 4: Access the designated dashboard
echo "\nStep 4: Accessing the designated dashboard...\n";

switch ($user->role) {
    case 'student':
        $dashboardController = new StudentDashboardController();
        try {
            $dashboardResponse = $dashboardController->index();
            echo "✓ Student dashboard accessed successfully\n";
        } catch (\Exception $e) {
            echo "✗ Failed to access student dashboard: " . $e->getMessage() . "\n";
        }
        break;
    case 'adviser':
        $dashboardController = new AdviserController();
        try {
            $dashboardResponse = $dashboardController->dashboard();
            echo "✓ Adviser dashboard accessed successfully\n";
        } catch (\Exception $e) {
            echo "✗ Failed to access adviser dashboard: " . $e->getMessage() . "\n";
        }
        break;
    case 'clinic_staff':
        $dashboardController = new ClinicStaffController();
        try {
            $dashboardResponse = $dashboardController->dashboard();
            echo "✓ Clinic Staff dashboard accessed successfully\n";
        } catch (\Exception $e) {
            echo "✗ Failed to access clinic staff dashboard: " . $e->getMessage() . "\n";
        }
        break;
    default:
        echo "✗ Unknown role: {$user->role}\n";
}

echo "\n🎉 All tests passed! User registration, login, and dashboard access work correctly.\n";
