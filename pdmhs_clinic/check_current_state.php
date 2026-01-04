<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CURRENT DATABASE STATE CHECK ===\n\n";

// Check all users
echo "ALL USERS:\n";
$users = \App\Models\User::all();
foreach($users as $user) {
    echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, Student_ID: " . ($user->student_id ?? 'NULL') . "\n";
}
echo "\n";

// Check all students
echo "ALL STUDENTS:\n";
$students = \App\Models\Student::all();
foreach($students as $student) {
    echo "- ID: {$student->id}, Name: {$student->first_name} {$student->last_name}, Student_ID: {$student->student_id}\n";
    echo "  Emergency Contact: " . ($student->emergency_contact_name ?? 'NULL') . "\n";
    echo "  Emergency Phone: " . ($student->emergency_contact_number ?? 'NULL') . "\n";
    echo "  Emergency Relation: " . ($student->emergency_relation ?? 'NULL') . "\n";
    echo "  Emergency Address: " . ($student->emergency_address ?? 'NULL') . "\n";
}
echo "\n";

// Check for specific student mentioned by user
echo "SEARCHING FOR JASMINE ROBELLE CABARGA DE LEON:\n";
$targetName = "JASMINE ROBELLE CABARGA DE LEON";
echo "Target name: {$targetName}\n";

$foundStudents = [];
foreach($students as $student) {
    $fullName = $student->first_name . ' ' . $student->last_name;
    if (strtolower($fullName) === strtolower($targetName) ||
        str_contains(strtolower($targetName), strtolower($fullName)) ||
        str_contains(strtolower($fullName), strtolower($targetName))) {
        $foundStudents[] = $student;
        echo "FOUND: {$fullName} (ID: {$student->id})\n";
    }
}

if (empty($foundStudents)) {
    echo "No exact matches found. Trying partial matching...\n";
    $nameParts = explode(' ', $targetName);
    foreach($students as $student) {
        $studentName = strtolower($student->first_name . ' ' . $student->last_name);
        $matchCount = 0;
        foreach($nameParts as $part) {
            if (str_contains($studentName, strtolower($part))) {
                $matchCount++;
            }
        }
        if ($matchCount >= 2) { // At least 2 parts match
            $foundStudents[] = $student;
            echo "PARTIAL MATCH: {$student->first_name} {$student->last_name} (ID: {$student->id})\n";
        }
    }
}

if (!empty($foundStudents)) {
    echo "\nDETAILED INFO FOR MATCHED STUDENTS:\n";
    foreach($foundStudents as $student) {
        echo "Student ID: {$student->id}\n";
        echo "Name: {$student->first_name} {$student->last_name}\n";
        echo "Has emergency data: " . (!empty($student->emergency_contact_name) ? 'YES' : 'NO') . "\n";

        // Check linked user
        $linkedUser = \App\Models\User::where('student_id', $student->id)->first();
        if ($linkedUser) {
            echo "Linked User: {$linkedUser->name} (ID: {$linkedUser->id})\n";
        } else {
            echo "No linked user found\n";
        }
        echo "---\n";
    }
} else {
    echo "No students found matching the target name\n";
}
