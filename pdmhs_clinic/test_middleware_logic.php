<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing middleware logic for student user...\n\n";

// Find the student user
$user = \App\Models\User::where('role', 'student')->first();
if (!$user) {
    echo "No student user found\n";
    exit;
}

echo "User: {$user->name} (ID: {$user->id})\n";
echo "User student_id: " . ($user->student_id ?? 'null') . "\n\n";

// Test the middleware logic
$middleware = new \App\Http\Middleware\CheckHealthForm();
$reflection = new ReflectionClass($middleware);
$method = $reflection->getMethod('studentHasAnyHealthData');
$method->setAccessible(true);

$result = $method->invoke($middleware, $user);

echo "Middleware result: " . ($result ? "HAS HEALTH DATA - SHOULD ALLOW ACCESS" : "NO HEALTH DATA - SHOULD REDIRECT") . "\n";

// Also test the getStudentForUser method
$getStudentMethod = $reflection->getMethod('getStudentForUser');
$getStudentMethod->setAccessible(true);

$student = $getStudentMethod->invoke($middleware, $user);

if ($student) {
    echo "Found student: {$student->first_name} {$student->last_name} (ID: {$student->id})\n";

    // Check the fields that the middleware checks
    $fields = [
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_relation',
        'emergency_address',
        'blood_type',
        'height',
        'weight',
        'allergies',
        'medical_conditions',
        'medication',
        'vaccination_history'
    ];

    echo "\nField values:\n";
    foreach ($fields as $field) {
        $value = $student->$field;
        $hasValue = false;

        if ($value !== null) {
            if (is_array($value)) {
                $hasValue = !empty($value);
            } else {
                $hasValue = trim((string)$value) !== '';
            }
        }

        echo "- {$field}: " . ($hasValue ? "HAS VALUE" : "EMPTY") . " (" . json_encode($value) . ")\n";
    }
} else {
    echo "No student found for user\n";
}
