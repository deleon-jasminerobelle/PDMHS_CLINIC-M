<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing student data check...\n\n";

$user = \App\Models\User::where('role', 'student')->first();
if ($user) {
    echo "User: {$user->name} (ID: {$user->id}, student_id: " . ($user->student_id ?? 'null') . ")\n";

    if ($user->student_id) {
        $student = \App\Models\Student::find($user->student_id);
        if ($student) {
            echo "Student: {$student->first_name} {$student->last_name}\n";
            echo "Emergency Contact Name: " . ($student->emergency_contact_name ?? 'null') . "\n";
            echo "Emergency Contact Number: " . ($student->emergency_contact_number ?? 'null') . "\n";
            echo "Emergency Relation: " . ($student->emergency_relation ?? 'null') . "\n";
            echo "Emergency Address: " . ($student->emergency_address ?? 'null') . "\n";

            // Test the hasCompleteHealthData logic
            $requiredFields = [
                'emergency_contact_name',
                'emergency_contact_number',
                'emergency_relation',
                'emergency_address'
            ];

            $hasCompleteData = true;
            foreach ($requiredFields as $field) {
                $value = $student->$field;
                if (empty($value)) {
                    echo "MISSING: {$field} = '{$value}'\n";
                    $hasCompleteData = false;
                } else {
                    echo "OK: {$field} = '{$value}'\n";
                }
            }

            echo "\nResult: " . ($hasCompleteData ? "COMPLETE" : "INCOMPLETE") . "\n";
        } else {
            echo "Student not found in database\n";
        }
    } else {
        echo "No student_id linked to user\n";
    }
} else {
    echo "No student user found in database\n";
}
