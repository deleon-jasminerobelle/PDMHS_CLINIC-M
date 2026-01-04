<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Debugging student health data...\n\n";

$user = \App\Models\User::where('role', 'student')->first();
if ($user) {
    echo "User: {$user->name} (ID: {$user->id})\n";
    echo "User student_id: " . ($user->student_id ?? 'null') . "\n\n";

    $student = null;
    if ($user->student_id) {
        $student = \App\Models\Student::find($user->student_id);
    }

    if (!$student) {
        echo "No student found by user.student_id, trying name matching...\n";
        // Try name matching like the middleware does
        $nameParts = array_filter(explode(' ', trim($user->name)));
        if (!empty($nameParts)) {
            for ($i = 1; $i < count($nameParts); $i++) {
                $possibleFirstName = implode(' ', array_slice($nameParts, 0, $i));
                $possibleLastName = implode(' ', array_slice($nameParts, $i));

                $student = \App\Models\Student::whereRaw('LOWER(first_name) = LOWER(?)', [$possibleFirstName])
                    ->whereRaw('LOWER(last_name) = LOWER(?)', [$possibleLastName])
                    ->first();

                if ($student) {
                    echo "Found student by name matching: {$possibleFirstName} {$possibleLastName}\n";
                    break;
                }
            }
        }
    }

    if ($student) {
        echo "Student: {$student->first_name} {$student->last_name} (ID: {$student->id})\n\n";

        // Check all health-related fields
        $healthFields = [
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address',
            'blood_type',
            'height',
            'weight',
            'temperature',
            'blood_pressure',
            'allergies',
            'medical_conditions',
            'medication',
            'vaccination_history',
            'has_allergies',
            'has_medical_condition',
            'has_surgery',
            'surgery_details',
            'family_history',
            'smoke_exposure'
        ];

        echo "Health data fields:\n";
        $hasAnyData = false;
        foreach ($healthFields as $field) {
            $value = $student->$field;
            $isEmpty = ($value === null || trim($value) === '' || $value === '[]' || $value === '{}');
            $status = $isEmpty ? 'EMPTY' : 'HAS DATA';

            if (!$isEmpty) {
                $hasAnyData = true;
            }

            echo "- {$field}: {$status}";
            if (!$isEmpty) {
                echo " ('{$value}')";
            }
            echo "\n";
        }

        echo "\nOverall result: " . ($hasAnyData ? "HAS HEALTH DATA" : "NO HEALTH DATA") . "\n";

        // Test the middleware logic
        $middlewareFields = [
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address',
            'blood_type',
            'height',
            'weight',
            'allergies',
            'medical_conditions',
            'medications'
        ];

        echo "\nMiddleware check fields:\n";
        $middlewareHasData = false;
        foreach ($middlewareFields as $field) {
            $value = $student->$field;
            if ($value !== null && trim($value) !== '') {
                $middlewareHasData = true;
                echo "- {$field}: HAS DATA ('{$value}')\n";
                break;
            } else {
                echo "- {$field}: EMPTY\n";
            }
        }

        echo "\nMiddleware result: " . ($middlewareHasData ? "WOULD ALLOW ACCESS" : "WOULD BLOCK ACCESS") . "\n";

    } else {
        echo "No student record found\n";
    }
} else {
    echo "No student user found\n";
}
