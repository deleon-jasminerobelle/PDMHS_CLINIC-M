<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "All students with emergency contact data:\n\n";

$students = \App\Models\Student::whereNotNull('emergency_contact_name')->get();

foreach($students as $student) {
    echo "ID: {$student->id}\n";
    echo "Name: {$student->first_name} {$student->last_name}\n";
    echo "Student ID: {$student->student_id}\n";
    echo "Emergency Contact: {$student->emergency_contact_name}\n";
    echo "Emergency Phone: {$student->emergency_contact_number}\n";
    echo "Emergency Relation: {$student->emergency_relation}\n";
    echo "Emergency Address: {$student->emergency_address}\n";

    // Check if user is linked
    $user = \App\Models\User::where('student_id', $student->id)->first();
    if ($user) {
        echo "Linked User: {$user->name} (ID: {$user->id})\n";
    } else {
        echo "No linked user found\n";
    }

    echo "---\n";
}

if ($students->count() == 0) {
    echo "No students found with emergency contact data\n";
}
