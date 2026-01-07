<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Adviser;
use App\Models\Student;

echo "=== Checking Zyrah De Leon's Students ===\n\n";

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

// Get Zyrah's students
$students = $adviser->students;
$studentCount = $students->count();

echo "✅ Zyrah has {$studentCount} students assigned\n\n";

if ($studentCount > 0) {
    echo "Sample students:\n";
    foreach ($students->take(5) as $student) {
        echo "- {$student->first_name} {$student->last_name} (Grade {$student->grade_level} {$student->section})\n";
    }

    if ($studentCount > 5) {
        echo "... and " . ($studentCount - 5) . " more students\n";
    }
} else {
    echo "❌ No students assigned to Zyrah!\n";
}

// Check total adviser-student relationships
$totalRelationships = \DB::table('student_adviser')->count();
echo "\nTotal adviser-student relationships in database: {$totalRelationships}\n";

echo "\n=== Test Complete ===\n";
