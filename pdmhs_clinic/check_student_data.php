<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;
use App\Models\User;

echo "=== STUDENT DATA CHECK ===\n\n";

// Get all students with health data
$students = Student::whereNotNull('height')
    ->orWhereNotNull('weight')
    ->orWhereNotNull('blood_type')
    ->orWhereNotNull('temperature')
    ->orWhereNotNull('blood_pressure')
    ->get();

echo "Students with health data:\n";
echo "Total: " . $students->count() . "\n\n";

foreach ($students as $student) {
    echo "Student ID: {$student->student_id}\n";
    echo "Name: {$student->first_name} {$student->last_name}\n";
    echo "Height: " . ($student->height ?: 'Not Set') . "\n";
    echo "Weight: " . ($student->weight ?: 'Not Set') . "\n";
    echo "Blood Type: " . ($student->blood_type ?: 'Not Set') . "\n";
    echo "Temperature: " . ($student->temperature ?: 'Not Set') . "\n";
    echo "Blood Pressure: " . ($student->blood_pressure ?: 'Not Set') . "\n";
    echo "---\n";
}

// Check if users are linked to students
echo "\n=== USER-STUDENT LINKING ===\n";
$users = User::where('role', 'student')->get();

foreach ($users as $user) {
    echo "User: {$user->name} (ID: {$user->id})\n";
    echo "Student ID: " . ($user->student_id ?: 'Not Linked') . "\n";

    if ($user->student_id) {
        $student = Student::find($user->student_id);
        if ($student) {
            echo "Linked Student: {$student->first_name} {$student->last_name}\n";
            echo "Student Data - Height: " . ($student->height ?: 'Not Set') . ", Weight: " . ($student->weight ?: 'Not Set') . "\n";
        } else {
            echo "ERROR: Student record not found!\n";
        }
    } else {
        // Try name matching
        $nameParts = explode(' ', $user->name);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $student = Student::where('first_name', $firstName)
                         ->where('last_name', $lastName)
                         ->first();

        if ($student) {
            echo "Name Match Found: {$student->first_name} {$student->last_name}\n";
            echo "Student Data - Height: " . ($student->height ?: 'Not Set') . ", Weight: " . ($student->weight ?: 'Not Set') . "\n";
        } else {
            echo "No student record found by name matching\n";
        }
    }
    echo "---\n";
}

echo "\n=== RECENT HEALTH FORM SUBMISSIONS ===\n";
// Check for recent updates (last 24 hours)
$recentStudents = Student::where('updated_at', '>=', now()->subDay())->get();

echo "Students updated in last 24 hours: " . $recentStudents->count() . "\n";

foreach ($recentStudents as $student) {
    echo "- {$student->first_name} {$student->last_name} (updated: {$student->updated_at})\n";
    echo "  Height: " . ($student->height ?: 'Not Set') . ", Weight: " . ($student->weight ?: 'Not Set') . "\n";
}
