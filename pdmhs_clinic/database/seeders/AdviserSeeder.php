<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adviser;
use App\Models\User;

class AdviserSeeder extends Seeder
{
    public function run()
    {
        // Create adviser users and adviser records
        $advisers = [
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria.santos@pdmhs.edu.ph',
                'employee_number' => 'ADV001',
                'contact_phone' => '09123456789',
                'is_active' => true,
            ],
            [
                'first_name' => 'Mario',
                'last_name' => 'Rodriguez',
                'email' => 'mario.rodriguez@pdmhs.edu.ph',
                'employee_number' => 'ADV002',
                'contact_phone' => '09123456790',
                'is_active' => true,
            ],
            [
                'first_name' => 'Mary Anne',
                'last_name' => 'Garcia',
                'email' => 'maryanne.garcia@pdmhs.edu.ph',
                'employee_number' => 'ADV003',
                'contact_phone' => '09123456791',
                'is_active' => true,
            ],
            [
                'first_name' => 'Nico',
                'last_name' => 'Cruz',
                'email' => 'nico.cruz@pdmhs.edu.ph',
                'employee_number' => 'ADV004',
                'contact_phone' => '09123456792',
                'is_active' => true,
            ],
        ];

        foreach ($advisers as $adviserData) {
            // Create or update user first
            $user = User::firstOrCreate(
                ['email' => $adviserData['email']],
                [
                    'name' => $adviserData['first_name'] . ' ' . $adviserData['last_name'],
                    'password' => bcrypt('password'),
                    'role' => 'adviser',
                ]
            );

            // Create or update adviser record
            Adviser::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $adviserData['first_name'],
                    'last_name' => $adviserData['last_name'],
                    'employee_number' => $adviserData['employee_number'],
                    'contact_phone' => $adviserData['contact_phone'],
                    'is_active' => $adviserData['is_active'],
                ]
            );
        }
    }
}
