<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Adviser;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AdviserAssignmentSeeder extends Seeder
{
    public function run()
    {
        // Define advisers with their assignments
        $advisers = [
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria.santos@pdmhs.edu.ph',
                'strands' => ['STEM'],
                'grades' => [11, 12]
            ],
            [
                'first_name' => 'Mario',
                'last_name' => 'Rodriguez',
                'email' => 'mario.rodriguez@pdmhs.edu.ph',
                'strands' => ['ABM'],
                'grades' => [11, 12]
            ],
            [
                'first_name' => 'Mary Anne',
                'last_name' => 'Garcia',
                'email' => 'maryanne.garcia@pdmhs.edu.ph',
                'strands' => ['HUMSS', 'GAS'],
                'grades' => [11, 12]
            ],
            [
                'first_name' => 'Nico',
                'last_name' => 'Cruz',
                'email' => 'nico.cruz@pdmhs.edu.ph',
                'strands' => [], // No specific strands assigned
                'grades' => []
            ]
        ];

        $employeeNumber = 1;

        foreach ($advisers as $adviserData) {
            // Create or update user
            $user = User::firstOrCreate(
                ['email' => $adviserData['email']],
                [
                    'name' => $adviserData['first_name'] . ' ' . $adviserData['last_name'],
                    'first_name' => $adviserData['first_name'],
                    'last_name' => $adviserData['last_name'],
                    'password' => Hash::make('password'),
                    'role' => 'adviser',
                ]
            );

            // Create or update adviser
            $adviser = Adviser::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $adviserData['first_name'],
                    'last_name' => $adviserData['last_name'],
                    'employee_number' => 'ADV-' . str_pad($employeeNumber++, 3, '0', STR_PAD_LEFT),
                    'contact_phone' => '+63 912 345 6789',
                    'is_active' => true,
                ]
            );

            // Assign students to adviser based on strands and grades
            if (!empty($adviserData['strands']) && !empty($adviserData['grades'])) {
                foreach ($adviserData['strands'] as $strand) {
                    foreach ($adviserData['grades'] as $grade) {
                        $students = Student::where('grade_level', $grade)
                            ->where('section', 'LIKE', $strand . '%')
                            ->get();

                        foreach ($students as $student) {
                            $adviser->students()->syncWithoutDetaching([
                                $student->id => ['assigned_date' => now()->format('Y-m-d')]
                            ]);
                        }
                    }
                }
            }
        }
    }
}
