<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;

echo "Checking for student with student_id '000001':\n";

$student = Student::where('student_id', '000001')->first();

if ($student) {
    echo "Student found:\n";
    echo "ID: " . $student->id . "\n";
    echo "Student ID: " . $student->student_id . "\n";
    echo "Name: " . $student->first_name . " " . $student->last_name . "\n";
    echo "Email: " . $student->email . "\n";
} else {
    echo "No student found with student_id '000001'\n";
    echo "Checking all students with student_id starting with '000':\n";
    $students = Student::where('student_id', 'like', '000%')->get();
    if ($students->count() > 0) {
        foreach ($students as $stu) {
            echo "ID: " . $stu->id . ", Student ID: " . $stu->student_id . ", Name: " . $stu->first_name . " " . $stu->last_name . "\n";
        }
    } else {
        echo "No students found with student_id starting with '000'\n";
    }
}
