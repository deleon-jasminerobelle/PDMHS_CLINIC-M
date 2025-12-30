<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;

class LinkUsersToStudentsSeeder extends Seeder
{
    public function run()
    {
        // Link student users to their corresponding student records
        $studentUsers = User::where('role', 'student')->get();

        foreach ($studentUsers as $user) {
            // Try to find student by name matching
            $nameParts = array_pad(explode(' ', trim($user->name)), 2, '');
            $firstName = $nameParts[0];
            $lastName = $nameParts[1];

            $student = Student::where('first_name', $firstName)
                             ->where('last_name', $lastName)
                             ->first();

            if ($student && !$user->student_id) {
                $user->update(['student_id' => $student->id]);
                echo "Linked user {$user->email} to student {$student->student_id} - {$student->first_name} {$student->last_name}\n";
            } elseif (!$student) {
                echo "No matching student found for user: {$user->email} ({$user->name})\n";
            }
        }

        // Also link clinic staff and adviser users if they have student_id fields (though they shouldn't)
        $otherUsers = User::whereIn('role', ['clinic_staff', 'adviser'])->whereNotNull('student_id')->get();
        foreach ($otherUsers as $user) {
            echo "Warning: Non-student user {$user->email} has student_id set to {$user->student_id}. This should be null.\n";
            $user->update(['student_id' => null]);
        }
    }
}
