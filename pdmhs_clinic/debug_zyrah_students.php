<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Adviser;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

echo "=== Detailed Zyrah Students Debug ===\n\n";

// Find Zyrah's user account
$user = User::where('email', 'zyrah.deleon@pdmhs.edu.ph')->first();
if (!$user) {
    echo "❌ Zyrah's user account not found!\n";
    exit(1);
}

echo "✅ Found Zyrah's user account (ID: {$user->id})\n";

// Find Zyrah's adviser record
$adviser = Adviser::where('user_id', $user->id)->first();
if (!$adviser) {
    echo "❌ Zyrah's adviser record not found!\n";
    exit(1);
}

echo "✅ Found Zyrah's adviser record (ID: {$adviser->id})\n";
echo "Adviser details: " . json_encode($adviser->toArray(), JSON_PRETTY_PRINT) . "\n\n";

// Check the pivot table directly
$pivotRecords = DB::table('student_adviser')->where('adviser_id', $adviser->id)->get();
echo "Direct pivot table records for Zyrah: " . $pivotRecords->count() . "\n";

if ($pivotRecords->count() > 0) {
    echo "Sample pivot records:\n";
    foreach ($pivotRecords->take(5) as $record) {
        echo "- Student ID: {$record->student_id}\n";
    }
    if ($pivotRecords->count() > 5) {
        echo "... and " . ($pivotRecords->count() - 5) . " more\n";
    }
}
echo "\n";

// Get students via relationship
$students = $adviser->students;
$studentCount = $students->count();

echo "Students via relationship: {$studentCount}\n";

if ($studentCount > 0) {
    echo "Sample students via relationship:\n";
    foreach ($students->take(5) as $student) {
        echo "- {$student->first_name} {$student->last_name} (ID: {$student->id}, Grade {$student->grade_level} {$student->section})\n";
    }
    if ($studentCount > 5) {
        echo "... and " . ($studentCount - 5) . " more\n";
    }
}
echo "\n";

// Check if there are students with Zyrah's LRN prefix
$zyrahStudents = Student::where('lrn', 'LIKE', 'ZYR%')->get();
echo "Students with ZYR LRN prefix: " . $zyrahStudents->count() . "\n";

if ($zyrahStudents->count() > 0) {
    echo "Sample ZYR students:\n";
    foreach ($zyrahStudents->take(5) as $student) {
        echo "- {$student->first_name} {$student->last_name} (LRN: {$student->lrn}, Grade {$student->grade_level} {$student->section})\n";
    }
}
echo "\n";

// Check total students in database
$totalStudents = Student::count();
echo "Total students in database: {$totalStudents}\n";

// Check total adviser-student relationships
$totalRelationships = DB::table('student_adviser')->count();
echo "Total adviser-student relationships: {$totalRelationships}\n";

echo "\n=== Debug Complete ===\n";
