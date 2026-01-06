<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Vitals;
use App\Models\HealthIncident;
use App\Models\ClinicVisit;
use App\Models\Student;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Checking and fixing database issues...\n\n";

// 1. Check for vitals without student_id and populate from clinic_visit
echo "1. Checking vitals without student_id...\n";
$vitalsWithoutStudentId = Vitals::whereNull('student_id')->whereNotNull('clinic_visit_id')->get();

if ($vitalsWithoutStudentId->count() > 0) {
    echo "Found {$vitalsWithoutStudentId->count()} vitals records without student_id. Fixing...\n";

    foreach ($vitalsWithoutStudentId as $vital) {
        $clinicVisit = ClinicVisit::find($vital->clinic_visit_id);
        if ($clinicVisit && $clinicVisit->student_id) {
            $vital->update(['student_id' => $clinicVisit->student_id]);
            echo "Updated vital ID {$vital->id} with student_id {$clinicVisit->student_id}\n";
        }
    }
} else {
    echo "No vitals records found without student_id.\n";
}

// 2. Check for health incidents without student_id (if any)
echo "\n2. Checking health incidents without student_id...\n";
$incidentsWithoutStudentId = HealthIncident::whereNull('student_id')->get();

if ($incidentsWithoutStudentId->count() > 0) {
    echo "Found {$incidentsWithoutStudentId->count()} health incident records without student_id.\n";
    echo "These may need manual review as they don't have clinic_visit relationship.\n";
} else {
    echo "No health incident records found without student_id.\n";
}

// 3. Check for invalid BMI values
echo "\n3. Checking for invalid BMI values...\n";
$studentsWithInvalidBmi = Student::whereNotNull('bmi')
    ->where(function($query) {
        $query->where('bmi', '<', 10)
              ->orWhere('bmi', '>', 50);
    })->get();

if ($studentsWithInvalidBmi->count() > 0) {
    echo "Found {$studentsWithInvalidBmi->count()} students with invalid BMI values. Setting to null...\n";

    foreach ($studentsWithInvalidBmi as $student) {
        echo "Student ID {$student->id}: BMI {$student->bmi} -> null\n";
        $student->update(['bmi' => null]);
    }
} else {
    echo "No students found with invalid BMI values.\n";
}

// 4. Check for duplicate student_id in users table
echo "\n4. Checking for duplicate student_id in users table...\n";
$duplicateStudentIds = DB::select("
    SELECT student_id, COUNT(*) as count
    FROM users
    WHERE student_id IS NOT NULL
    GROUP BY student_id
    HAVING COUNT(*) > 1
");

if (count($duplicateStudentIds) > 0) {
    echo "Found duplicate student_id assignments in users table:\n";
    foreach ($duplicateStudentIds as $dup) {
        echo "Student ID {$dup->student_id} is assigned to {$dup->count} users\n";

        // Keep only the first user, remove others
        $users = DB::table('users')->where('student_id', $dup->student_id)->get();
        $firstUser = true;
        foreach ($users as $user) {
            if (!$firstUser) {
                DB::table('users')->where('id', $user->id)->update(['student_id' => null]);
                echo "Removed student_id from user ID {$user->id}\n";
            }
            $firstUser = false;
        }
    }
} else {
    echo "No duplicate student_id assignments found in users table.\n";
}

// 5. Check for students with missing required fields that might cause issues
echo "\n5. Checking for students with missing critical data...\n";
$studentsWithIssues = Student::whereNull('first_name')
    ->orWhereNull('last_name')
    ->get();

if ($studentsWithIssues->count() > 0) {
    echo "Found {$studentsWithIssues->count()} students with missing critical data:\n";
    foreach ($studentsWithIssues as $student) {
        echo "Student ID {$student->id}: Missing " .
             (is_null($student->first_name) ? 'first_name ' : '') .
             (is_null($student->last_name) ? 'last_name ' : '') . "\n";
    }
} else {
    echo "All students have required critical data.\n";
}

echo "\nDatabase check and fix completed!\n";
