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
        // Create test students
        $students = [
            [
                'student_id' => 'STU-001',
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'date_of_birth' => '2008-05-15',
                'grade_level' => 10,
                'section' => 'A',
                'contact_number' => '+63 912 345 6789',
                'emergency_contact_name' => 'Maria Dela Cruz',
                'emergency_contact_number' => '+63 912 345 6790',
                'address' => '123 Main St, Manila'
            ],
            [
                'student_id' => 'STU-002',
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'date_of_birth' => '2008-08-22',
                'grade_level' => 10,
                'section' => 'A',
                'contact_number' => '+63 912 345 6791',
                'emergency_contact_name' => 'Jose Santos',
                'emergency_contact_number' => '+63 912 345 6792',
                'address' => '456 Oak Ave, Quezon City'
            ],
            [
                'student_id' => 'STU-003',
                'first_name' => 'Pedro',
                'last_name' => 'Garcia',
                'date_of_birth' => '2008-12-10',
                'grade_level' => 10,
                'section' => 'B',
                'contact_number' => '+63 912 345 6793',
                'emergency_contact_name' => 'Ana Garcia',
                'emergency_contact_number' => '+63 912 345 6794',
                'address' => '789 Pine St, Makati'
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