<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;

echo "Testing QR lookup logic...\n";
echo "========================\n";

$studentId = '000001'; // From QR code
echo "Looking for student with ID: {$studentId}\n\n";

// Test the exact query from processQR
$student = Student::with('user')
    ->where('lrn', $studentId)
    ->orWhereRaw("LPAD(id, 6, '0') = ?", [$studentId])
    ->first();

if ($student) {
    echo "Student found!\n";
    echo "ID: {$student->id}\n";
    echo "Name: {$student->first_name} {$student->last_name}\n";
    echo "LRN: " . ($student->lrn ?? 'null') . "\n";
    echo "Formatted ID: {$student->getFormattedStudentNumberAttribute()}\n";
    echo "Student ID accessor: {$student->student_id}\n";
} else {
    echo "Student NOT found!\n";

    // Debug individual parts
    echo "\nDebugging:\n";
    echo "Students with lrn = '{$studentId}': " . Student::where('lrn', $studentId)->count() . "\n";

    $rawQuery = "LPAD(id, 6, '0') = '{$studentId}'";
    echo "Students with {$rawQuery}: " . Student::whereRaw($rawQuery)->count() . "\n";

    // Show first few students
    echo "\nFirst 5 students:\n";
    $students = Student::take(5)->get();
    foreach ($students as $stu) {
        $formatted = str_pad($stu->id, 6, '0', STR_PAD_LEFT);
        echo "ID: {$stu->id}, Formatted: {$formatted}, LRN: " . ($stu->lrn ?? 'null') . "\n";
    }
}
