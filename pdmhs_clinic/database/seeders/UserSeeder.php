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

        // Create student users
        User::firstOrCreate(
            ['email' => 'student@pdmhs.edu.ph'],
            [
                'name' => 'Clarence Villas',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        User::firstOrCreate(
            ['email' => 'student2@pdmhs.edu.ph'],
            [
                'name' => 'Student Two',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        User::firstOrCreate(
            ['email' => 'student3@pdmhs.edu.ph'],
            [
                'name' => 'Student Three',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );
    }
}