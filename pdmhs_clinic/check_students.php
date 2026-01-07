<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;

echo "Students in database:\n";
echo "===================\n";

$students = Student::take(5)->get(['id', 'lrn', 'first_name', 'last_name']);

foreach ($students as $student) {
    $studentId = $student->student_id ?? 'null';
    $lrn = $student->lrn ?? 'null';

    echo "ID: {$student->id}\n";
    echo "  Name: {$student->first_name} {$student->last_name}\n";
    echo "  student_id: {$studentId}\n";
    echo "  lrn: {$lrn}\n";
    echo "  Formatted: {$student->getFormattedStudentNumberAttribute()}\n";
    echo "---\n";
}
