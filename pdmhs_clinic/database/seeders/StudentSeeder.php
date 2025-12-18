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
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '2010-05-15',
            'grade_level' => 5,
            'section' => 'A',
            'contact_number' => '123-456-7890',
            'emergency_contact_name' => 'Jane Doe',
            'emergency_contact_number' => '098-765-4321',
            'address' => '123 Main St, City, State',
        ]);

        Student::create([
            'student_id' => 'STU002',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'date_of_birth' => '2011-03-22',
            'grade_level' => 4,
            'section' => 'B',
            'contact_number' => '234-567-8901',
            'emergency_contact_name' => 'Bob Smith',
            'emergency_contact_number' => '987-654-3210',
            'address' => '456 Elm St, City, State',
        ]);

        Student::create([
            'student_id' => 'STU003',
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'date_of_birth' => '2009-12-10',
            'grade_level' => 6,
            'section' => 'A',
            'contact_number' => '345-678-9012',
            'emergency_contact_name' => 'Charlie Johnson',
            'emergency_contact_number' => '876-543-2109',
            'address' => '789 Oak St, City, State',
        ]);
    }
}
