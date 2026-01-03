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
            // Skip if already linked and the link is valid
            if ($user->student_id) {
                $existingStudent = Student::find($user->student_id);
                if ($existingStudent) {
                    echo "User {$user->email} already linked to valid student {$existingStudent->student_id} - {$existingStudent->first_name} {$existingStudent->last_name}\n";
                    continue;
                } else {
                    echo "User {$user->email} has invalid student_id {$user->student_id}, attempting to relink...\n";
                    $user->update(['student_id' => null]);
                }
            }

            // Try to find student by improved name matching
            $student = $this->findStudentByName($user->name);

            if ($student) {
                $user->update(['student_id' => $student->id]);
                echo "Linked user {$user->email} to student {$student->student_id} - {$student->first_name} {$student->last_name}\n";
            } else {
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

    /**
     * Find student by name using improved logic to handle middle names and complex names
     */
    private function findStudentByName($userName)
    {
        $nameParts = array_filter(explode(' ', trim($userName)));

        if (empty($nameParts)) {
            return null;
        }

        // Strategy 1: Try to match by reconstructing the name
        // For names like "JASMINE ROBELLE CABARGA DE LEON"
        // Student record might have first_name = "JASMINE ROBELLE", last_name = "CABARGA DE LEON"

        for ($i = 1; $i < count($nameParts); $i++) {
            $possibleFirstName = implode(' ', array_slice($nameParts, 0, $i));
            $possibleLastName = implode(' ', array_slice($nameParts, $i));

            $student = Student::whereRaw('LOWER(first_name) = LOWER(?)', [$possibleFirstName])
                ->whereRaw('LOWER(last_name) = LOWER(?)', [$possibleLastName])
                ->first();

            if ($student) {
                return $student;
            }
        }

        // Strategy 2: Try exact match with first and last parts
        $firstName = $nameParts[0];
        $lastName = end($nameParts);

        $student = Student::whereRaw('LOWER(first_name) = LOWER(?)', [$firstName])
            ->whereRaw('LOWER(last_name) = LOWER(?)', [$lastName])
            ->first();

        if ($student) {
            return $student;
        }

        // Strategy 3: Try to find student where the user name contains the student name
        $allStudents = Student::all();
        foreach ($allStudents as $student) {
            $fullStudentName = strtolower($student->first_name . ' ' . $student->last_name);
            $userNameLower = strtolower($userName);

            // Check if user name contains student name or vice versa
            if (str_contains($userNameLower, $fullStudentName) || str_contains($fullStudentName, $userNameLower)) {
                return $student;
            }
        }

        // Strategy 4: Try partial matching - match first name and check if last name parts match
        foreach ($allStudents as $student) {
            $studentFirstName = strtolower($student->first_name);
            $studentLastNameParts = explode(' ', strtolower($student->last_name));

            if (strtolower($firstName) === $studentFirstName) {
                // Check if any part of the user's name matches the student's last name parts
                foreach ($nameParts as $part) {
                    if (in_array(strtolower($part), $studentLastNameParts)) {
                        return $student;
                    }
                }
            }
        }

        return null;
    }
}
