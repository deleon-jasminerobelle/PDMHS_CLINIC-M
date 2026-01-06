<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\Vitals;

echo "Checking for invalid BMI values in students table...\n";

$invalidBmis = Student::whereNotNull('bmi')
    ->where(function($query) {
        $query->where('bmi', '>', 50)
              ->orWhere('bmi', '<', 10);
    })
    ->get(['id', 'first_name', 'last_name', 'bmi', 'weight', 'height']);

if ($invalidBmis->count() > 0) {
    echo "Found " . $invalidBmis->count() . " students with invalid BMI:\n";
    foreach ($invalidBmis as $student) {
        echo "ID: {$student->id}, Name: {$student->first_name} {$student->last_name}, BMI: {$student->bmi}, Weight: {$student->weight}, Height: {$student->height}\n";
    }
} else {
    echo "No invalid BMI values found in students table.\n";
}

echo "\nChecking vitals table for missing student_id...\n";

$missingStudentId = Vitals::whereNull('student_id')->count();
echo "Vitals records without student_id: {$missingStudentId}\n";

echo "\nChecking health_incidents table for missing student_id...\n";

$missingStudentIdIncidents = \App\Models\HealthIncident::whereNull('student_id')->count();
echo "Health incident records without student_id: {$missingStudentIdIncidents}\n";

echo "\nChecking students table for missing middle_name...\n";

$missingMiddleName = Student::whereNull('middle_name')->orWhere('middle_name', '')->count();
echo "Students without middle_name: {$missingMiddleName}\n";
