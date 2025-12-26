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
            'grade_level' => '10',
            'section' => 'A',
            'contact_number' => null,
            'emergency_contact_name' => null,
            'emergency_contact_number' => null,
            'address' => null,
            'allergies' => ['Peanuts', 'Shellfish'],
        ]);

        Student::create([
            'student_id' => 'STU002',
            'first_name' => 'Student',
            'last_name' => 'Two',
            'date_of_birth' => null,
            'grade_level' => '10',
            'section' => 'A',
            'contact_number' => null,
            'emergency_contact_name' => null,
            'emergency_contact_number' => null,
            'address' => null,
            'allergies' => ['Dust'],
        ]);

        Student::create([
            'student_id' => 'STU003',
            'first_name' => 'Student',
            'last_name' => 'Three',
            'date_of_birth' => null,
            'grade_level' => '10',
            'section' => 'B',
            'contact_number' => null,
            'emergency_contact_name' => null,
            'emergency_contact_number' => null,
            'address' => null,
            'allergies' => [],
        ]);

        // Add the specific student mentioned by user for testing
        Student::create([
            'student_id' => 'STU004',
            'first_name' => 'JASMINE ROBELLE',
            'last_name' => 'CABARGA DE LEON',
            'date_of_birth' => '2005-06-15',
            'grade_level' => '12',
            'section' => 'A',
            'contact_number' => '09123456789',
            'emergency_contact_name' => 'Maria De Leon',
            'emergency_contact_number' => '09123456788',
            'address' => '123 Sample Street, Manila',
            'sex' => 'F',
            'allergies' => ['Milk', 'Eggs'],
        ]);
    }
}
