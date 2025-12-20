<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;

class UpdateClarenceVillasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update the user record
        $user = User::where('email', 'student@pdmhs.edu.ph')->first();
        if ($user) {
            $user->update(['name' => 'Clarence Villas']);
        }

        // Update the student record
        $student = Student::where('student_id', 'STU001')->first();
        if ($student) {
            $student->update([
                'first_name' => 'Clarence',
                'last_name' => 'Villas'
            ]);
        }

        // Also update STU-001 if it exists
        $student2 = Student::where('student_id', 'STU-001')->first();
        if ($student2) {
            $student2->update([
                'first_name' => 'Clarence',
                'last_name' => 'Villas'
            ]);
        }
    }
}