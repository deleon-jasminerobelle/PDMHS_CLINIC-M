<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestStudentSeeder extends Seeder
{
    public function run()
    {
        // Create test students with minimal data
        $students = [
            [
                'student_id' => 'STU-001',
                'first_name' => 'Clarence',
                'last_name' => 'Villas',
                'date_of_birth' => null,
                'grade_level' => null,
                'section' => null,
                'contact_number' => null,
                'emergency_contact_name' => null,
                'emergency_contact_number' => null,
                'address' => null
            ],
            [
                'student_id' => 'STU-002',
                'first_name' => 'Student',
                'last_name' => 'Two',
                'date_of_birth' => null,
                'grade_level' => null,
                'section' => null,
                'contact_number' => null,
                'emergency_contact_name' => null,
                'emergency_contact_number' => null,
                'address' => null
            ],
            [
                'student_id' => 'STU-003',
                'first_name' => 'Student',
                'last_name' => 'Three',
                'date_of_birth' => null,
                'grade_level' => null,
                'section' => null,
                'contact_number' => null,
                'emergency_contact_name' => null,
                'emergency_contact_number' => null,
                'address' => null
            ]
        ];

        foreach ($students as $studentData) {
            Student::firstOrCreate(
                ['student_id' => $studentData['student_id']],
                $studentData
            );
        }
    }
}