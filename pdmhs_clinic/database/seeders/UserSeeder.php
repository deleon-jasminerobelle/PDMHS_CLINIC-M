<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
=======
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
<<<<<<< HEAD
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
=======
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
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
