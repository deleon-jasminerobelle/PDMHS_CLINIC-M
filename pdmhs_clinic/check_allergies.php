<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Student;

echo "Checking allergies in database...\n\n";

$user = User::where('email', 'like', '%student%')->first();

if ($user) {
    echo "Found user: {$user->email}\n";
    echo "Student ID: {$user->student_id}\n\n";

    $student = Student::find($user->student_id);

    if ($student) {
        echo "Student: {$student->first_name} {$student->last_name}\n";
        echo "Allergies data: " . json_encode($student->allergies, JSON_PRETTY_PRINT) . "\n";
        echo "Has allergies flag: " . ($student->has_allergies ? 'true' : 'false') . "\n\n";

        // Test the trait method
        $service = new class { use App\Traits\StudentHealthService; };
        $allergies = $service->getAllergiesForStudent($student);
        echo "Allergies from trait method: " . json_encode($allergies, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "Student record not found\n";
    }
} else {
    echo "No student user found\n";
}
