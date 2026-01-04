<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing student login logic for Student Two...\n\n";

$user = \App\Models\User::find(7); // Student Two
if ($user) {
    echo "User: {$user->name} (ID: {$user->id})\n";
    echo "Student ID: {$user->student_id}\n\n";

    // Check student data directly (simulate what studentHasData does)
    $hasData = false;
    if ($user->student_id) {
        $student = \App\Models\Student::find($user->student_id);
        if ($student) {
            $requiredFields = [
                'emergency_contact_name',
                'emergency_contact_number',
                'emergency_relation',
                'emergency_address'
            ];

            $hasData = true;
            foreach ($requiredFields as $field) {
                $value = $student->$field;
                if (empty($value)) {
                    $hasData = false;
                    break;
                }
            }
        }
    }

    echo "studentHasData() result: " . ($hasData ? 'TRUE' : 'FALSE') . "\n";

    if ($hasData) {
        echo "✓ Student should be redirected to DASHBOARD\n";
    } else {
        echo "✗ Student should be redirected to HEALTH FORM\n";
    }

    if ($user->student_id) {
        $student = \App\Models\Student::find($user->student_id);
        if ($student) {
            echo "\nStudent record found:\n";
            echo "- Emergency Contact Name: {$student->emergency_contact_name}\n";
            echo "- Emergency Contact Number: {$student->emergency_contact_number}\n";
            echo "- Emergency Relation: {$student->emergency_relation}\n";
            echo "- Emergency Address: {$student->emergency_address}\n";
        }
    }
} else {
    echo "User not found\n";
}
