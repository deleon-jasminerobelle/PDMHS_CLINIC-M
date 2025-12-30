<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckHealthForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            \Illuminate\Support\Facades\Log::info('CheckHealthForm middleware triggered', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'student_id' => $user->student_id,
                'route' => $request->route() ? $request->route()->getName() : 'unknown'
            ]);

            if ($user->role === 'admin') {
                return $next($request);
            }
            if ($user->role === 'student') {
                // For students, allow dashboard access regardless of student record linking
                // The dashboard will handle missing data gracefully and show appropriate messages
                // This prevents students from being stuck in redirect loops due to name matching issues

                \Illuminate\Support\Facades\Log::info('Student accessing dashboard', [
                    'user_id' => $user->id,
                    'has_student_id' => $user->student_id ? true : false,
                    'student_id' => $user->student_id
                ]);

                // Try to link student record if not already linked, but don't block access if it fails
                if (!$user->student_id) {
                    $student = $this->findStudentByName($user->name);
                    if ($student) {
                        \App\Models\User::where('id', $user->id)->update(['student_id' => $student->id]);
                        \Illuminate\Support\Facades\Log::info('Linked user to student in middleware', [
                            'user_id' => $user->id,
                            'student_id' => $student->id,
                            'student_name' => $student->first_name . ' ' . $student->last_name
                        ]);
                    }
                }

                // Store student_profile in session for later use
                $request->session()->put('student_profile', true);
            }
        }
        return $next($request);
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

        \Illuminate\Support\Facades\Log::info('Finding student by name', [
            'user_name' => $userName,
            'name_parts' => $nameParts
        ]);

        // Try different combinations to match the student record
        // For names like "JASMINE ROBELLE CABARGA DE LEON"
        // Student record might have first_name = "JASMINE ROBELLE", last_name = "CABARGA DE LEON"

        // Strategy 1: Try to match by reconstructing the name
        // Assume first name might include middle names
        for ($i = 1; $i < count($nameParts); $i++) {
            $possibleFirstName = implode(' ', array_slice($nameParts, 0, $i));
            $possibleLastName = implode(' ', array_slice($nameParts, $i));

            \Illuminate\Support\Facades\Log::info('Trying name combination', [
                'first_name_attempt' => $possibleFirstName,
                'last_name_attempt' => $possibleLastName
            ]);

            $student = \App\Models\Student::whereRaw('LOWER(first_name) = LOWER(?)', [$possibleFirstName])
                ->whereRaw('LOWER(last_name) = LOWER(?)', [$possibleLastName])
                ->first();

            if ($student) {
                \Illuminate\Support\Facades\Log::info('Found student with reconstructed name match', [
                    'student_id' => $student->id,
                    'student_name' => $student->first_name . ' ' . $student->last_name,
                    'matched_first' => $possibleFirstName,
                    'matched_last' => $possibleLastName
                ]);
                return $student;
            }
        }

        // Strategy 2: Try exact match with first and last parts
        $firstName = $nameParts[0];
        $lastName = end($nameParts);

        $student = \App\Models\Student::whereRaw('LOWER(first_name) = LOWER(?)', [$firstName])
            ->whereRaw('LOWER(last_name) = LOWER(?)', [$lastName])
            ->first();

        if ($student) {
            \Illuminate\Support\Facades\Log::info('Found student with first/last match', [
                'student_id' => $student->id,
                'student_name' => $student->first_name . ' ' . $student->last_name
            ]);
            return $student;
        }

        // Strategy 3: Try to find student where the user name contains the student name
        $allStudents = \App\Models\Student::all();
        foreach ($allStudents as $student) {
            $fullStudentName = strtolower($student->first_name . ' ' . $student->last_name);
            $userNameLower = strtolower($userName);

            // Check if user name contains student name or vice versa
            if (str_contains($userNameLower, $fullStudentName) || str_contains($fullStudentName, $userNameLower)) {
                \Illuminate\Support\Facades\Log::info('Found student with partial name match', [
                    'student_id' => $student->id,
                    'student_name' => $student->first_name . ' ' . $student->last_name,
                    'user_name' => $userName
                ]);
                return $student;
            }
        }

        \Illuminate\Support\Facades\Log::info('No student found for name', [
            'user_name' => $userName
        ]);
        return null;
    }

    /**
     * Check if a student has complete health data required for dashboard display
     */
    private function hasCompleteHealthData($student)
    {
        // Check for essential health data fields that are required by the health form
        // Only check fields that are actually required in form validation
        $requiredFields = [
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address'
        ];

        foreach ($requiredFields as $field) {
            $value = $student->$field;
            // Check if field is null, empty string, or only whitespace
            if ($value === null || trim($value) === '') {
                \Illuminate\Support\Facades\Log::info('Missing required field in middleware check', [
                    'field' => $field,
                    'value' => $value,
                    'student_id' => $student->id
                ]);
                return false;
            }
        }

        return true;
    }
}
