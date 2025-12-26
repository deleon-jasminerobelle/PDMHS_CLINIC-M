<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@pdmhs.edu.ph'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create clinic staff user
        User::firstOrCreate(
            ['email' => 'nurse@pdmhs.edu.ph'],
            [
                'name' => 'Maria Santos',
                'password' => Hash::make('nurse123'),
                'role' => 'clinic_staff',
            ]
        );

        // Create adviser user
        User::firstOrCreate(
            ['email' => 'adviser@pdmhs.edu.ph'],
            [
                'name' => 'Roberto Cruz',
                'password' => Hash::make('adviser123'),
                'role' => 'adviser',
            ]
        );

        // Create student users and link to students
        $studentUser1 = User::firstOrCreate(
            ['email' => 'student@pdmhs.edu.ph'],
            [
                'name' => 'Clarence Villas',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        $studentUser2 = User::firstOrCreate(
            ['email' => 'student2@pdmhs.edu.ph'],
            [
                'name' => 'Student Two',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        $studentUser3 = User::firstOrCreate(
            ['email' => 'student3@pdmhs.edu.ph'],
            [
                'name' => 'Student Three',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        // Link users to students (assuming students are already seeded)
        $student1 = \App\Models\Student::where('student_id', 'STU001')->first();
        if ($student1 && !$studentUser1->student_id) {
            $studentUser1->update(['student_id' => $student1->id]);
        }

        $student2 = \App\Models\Student::where('student_id', 'STU002')->first();
        if ($student2 && !$studentUser2->student_id) {
            $studentUser2->update(['student_id' => $student2->id]);
        }

        $student3 = \App\Models\Student::where('student_id', 'STU003')->first();
        if ($student3 && !$studentUser3->student_id) {
            $studentUser3->update(['student_id' => $student3->id]);
        }
    }
}