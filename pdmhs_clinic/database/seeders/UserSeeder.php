<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pdmhs.edu.ph',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Clinic Staff user
        User::create([
            'name' => 'Clinic Staff',
            'email' => 'nurse@pdmhs.edu.ph',
            'password' => Hash::make('nurse123'),
            'role' => 'clinic_staff',
        ]);

        // Adviser user
        User::create([
            'name' => 'Adviser',
            'email' => 'adviser@pdmhs.edu.ph',
            'password' => Hash::make('adviser123'),
            'role' => 'adviser',
        ]);

        // Student user
        User::create([
            'name' => 'Student',
            'email' => 'student@pdmhs.edu.ph',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'student_id' => 'STU001', // Link to seeded student
        ]);
    }
}
