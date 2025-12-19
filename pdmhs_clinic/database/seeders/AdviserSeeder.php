<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Adviser;
use App\Models\Student;

class AdviserSeeder extends Seeder
{
    public function run()
    {
        // Get the adviser user
        $adviserUser = User::where('email', 'adviser@pdmhs.edu.ph')->first();
        
        if ($adviserUser) {
            // Create adviser record
            $adviser = Adviser::firstOrCreate(
                ['user_id' => $adviserUser->id],
                [
                    'first_name' => 'Roberto',
                    'last_name' => 'Cruz',
                    'employee_number' => 'ADV-001',
                    'contact_phone' => '+63 912 345 6789',
                    'is_active' => true,
                ]
            );

            // Assign some students to this adviser (if students exist)
            $students = Student::limit(3)->get();
            if ($students->count() > 0) {
                foreach ($students as $student) {
                    $adviser->students()->syncWithoutDetaching([
                        $student->id => ['assigned_date' => now()->format('Y-m-d')]
                    ]);
                }
            }
        }
    }
}