<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentUserSeeder extends Seeder
{
    public function run()
    {
        $student = Student::first();
        
        if ($student) {
            User::create([
                'name' => $student->first_name . ' ' . $student->last_name,
                'email' => strtolower($student->first_name . '.' . $student->last_name . '@student.pdmhs.edu'),
                'password' => Hash::make('student123'),
                'role' => 'student'
            ]);
            
            echo "Created user for student: {$student->student_id} - {$student->first_name} {$student->last_name}\n";
        }
    }
}