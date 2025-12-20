<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'student_id' => 'STU001',
            'first_name' => 'Clarence',
            'last_name' => 'Villas',
            'date_of_birth' => null,
            'grade_level' => null,
            'section' => null,
            'contact_number' => null,
            'emergency_contact_name' => null,
            'emergency_contact_number' => null,
            'address' => null,
        ]);

        Student::create([
            'student_id' => 'STU002',
            'first_name' => 'Student',
            'last_name' => 'Two',
            'date_of_birth' => null,
            'grade_level' => null,
            'section' => null,
            'contact_number' => null,
            'emergency_contact_name' => null,
            'emergency_contact_number' => null,
            'address' => null,
        ]);

        Student::create([
            'student_id' => 'STU003',
            'first_name' => 'Student',
            'last_name' => 'Three',
            'date_of_birth' => null,
            'grade_level' => null,
            'section' => null,
            'contact_number' => null,
            'emergency_contact_name' => null,
            'emergency_contact_number' => null,
            'address' => null,
        ]);
    }
}
