<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Adding test health data...\n\n";

$user = \App\Models\User::where('role', 'student')->first();
if ($user) {
    echo "User: {$user->name} (ID: {$user->id})\n";

    $student = null;
    if ($user->student_id) {
        $student = \App\Models\Student::find($user->student_id);
    }

    if (!$student) {
        // Try name matching
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
        echo "Student: {$student->first_name} {$student->last_name} (ID: {$student->id})\n";

        // Add some basic health data
        $updateData = [
            'emergency_contact_name' => 'Test Parent',
            'emergency_contact_number' => '09123456789',
            'emergency_relation' => 'Parent',
            'emergency_address' => 'Test Address',
            'blood_type' => 'O+',
            'height' => 160,
            'weight' => 50,
            'allergies' => json_encode(['Peanuts']),
            'vaccination_history' => json_encode(['BCG' => ['given' => 'yes', 'date' => '2020-01-01']])
        ];

        $student->update($updateData);

        echo "Added test health data:\n";
        foreach ($updateData as $field => $value) {
            echo "- {$field}: {$value}\n";
        }

        echo "\nTest data added successfully!\n";

    } else {
        echo "No student record found\n";
    }
} else {
    echo "No student user found\n";
}
