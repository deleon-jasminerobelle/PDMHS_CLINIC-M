<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;
use App\Models\User;

echo "Checking student emergency contact data...\n\n";

$students = Student::all();

foreach ($students as $student) {
    echo "Student ID: {$student->id} ({$student->first_name} {$student->last_name})\n";
    echo "Emergency Contact Name: " . ($student->emergency_contact_name ?: 'MISSING') . "\n";
    echo "Emergency Contact Number: " . ($student->emergency_contact_number ?: 'MISSING') . "\n";
    echo "Emergency Relation: " . ($student->emergency_relation ?: 'MISSING') . "\n";
    echo "Emergency Address: " . ($student->emergency_address ?: 'MISSING') . "\n";
    echo "Health Form Completed: " . ($student->health_form_completed ? 'YES' : 'NO') . "\n";
    echo "---\n";
}

echo "\nChecking users with student role...\n\n";

$studentUsers = User::where('role', 'student')->get();

foreach ($studentUsers as $user) {
    echo "User ID: {$user->id} ({$user->name})\n";
    echo "Student ID: " . ($user->student_id ?: 'MISSING') . "\n";

    if ($user->student_id) {
        $student = Student::find($user->student_id);
        if ($student) {
            echo "Emergency Contact Complete: " . (
                $student->emergency_contact_name &&
                $student->emergency_contact_number &&
                $student->emergency_relation &&
                $student->emergency_address ? 'YES' : 'NO'
            ) . "\n";
        } else {
            echo "Student record not found!\n";
        }
    }
    echo "---\n";
}
