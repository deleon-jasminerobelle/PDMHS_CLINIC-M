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
                'name' => 'Juan Dela Cruz',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        User::firstOrCreate(
            ['email' => 'maria.garcia@pdmhs.edu.ph'],
            [
                'name' => 'Maria Garcia',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );

        User::firstOrCreate(
            ['email' => 'pedro.santos@pdmhs.edu.ph'],
            [
                'name' => 'Pedro Santos',
                'password' => Hash::make('student123'),
                'role' => 'student',
            ]
        );
    }
}