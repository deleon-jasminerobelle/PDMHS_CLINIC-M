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
            if ($user->role === 'admin') {
                return $next($request);
            }
            if ($user->role === 'student') {
                // Check if user has student_id and if student exists in database
                if (!$user->student_id) {
                    // Try to link user to existing student by name
                    $student = $this->findStudentByName($user->name);
                    if ($student) {
                        \App\Models\User::where('id', $user->id)->update(['student_id' => $student->id]);
                        \Illuminate\Support\Facades\Log::info('Linked user to student in middleware', [
                            'user_id' => $user->id,
                            'student_id' => $student->id,
                            'student_name' => $student->first_name . ' ' . $student->last_name
                        ]);
                    } else {
                        return redirect()->route('student-health-form');
                    }
                }

                $student = \App\Models\Student::find($user->student_id);
                if (!$student) {
                    // Try to find student by name as fallback
                    $student = $this->findStudentByName($user->name);
                    if ($student) {
                        \App\Models\User::where('id', $user->id)->update(['student_id' => $student->id]);
                        \Illuminate\Support\Facades\Log::info('Relinked user to student in middleware', [
                            'user_id' => $user->id,
                            'student_id' => $student->id,
                            'student_name' => $student->first_name . ' ' . $student->last_name
                        ]);
                    } else {
                        return redirect()->route('student-health-form');
                    }
                }

                // Store student_profile in session for later use
                $request->session()->put('student_profile', true);
            }
        }
        return $next($request);
    }

    /**
     * Find student by name with flexible matching
     */
    private function findStudentByName($userName)
    {
        $nameParts = explode(' ', trim($userName));
        if (count($nameParts) >= 2) {
            $firstName = $nameParts[0];

            // Try different combinations for last name (handle multiple last names)
            $possibleLastNames = [];

            // Try last part only
            $possibleLastNames[] = end($nameParts);

            // Try last two parts (for names like "DE LEON")
            if (count($nameParts) >= 3) {
                $possibleLastNames[] = $nameParts[count($nameParts) - 2] . ' ' . end($nameParts);
            }

            // Try last three parts (for names like "CABARGA DE LEON")
            if (count($nameParts) >= 4) {
                $possibleLastNames[] = $nameParts[count($nameParts) - 3] . ' ' . $nameParts[count($nameParts) - 2] . ' ' . end($nameParts);
            }

            // Try all combinations with case-insensitive matching
            foreach ($possibleLastNames as $lastName) {
                // Try exact match first
                $student = \App\Models\Student::where('first_name', 'like', $firstName)
                    ->where('last_name', 'like', $lastName)
                    ->first();

                if ($student) {
                    return $student;
                }

                // Try case-insensitive match
                $student = \App\Models\Student::whereRaw('LOWER(first_name) LIKE LOWER(?)', [$firstName])
                    ->whereRaw('LOWER(last_name) LIKE LOWER(?)', [$lastName])
                    ->first();

                if ($student) {
                    return $student;
                }
            }

            // Try partial matching - search for any student containing the first name
            $studentsWithFirstName = \App\Models\Student::where('first_name', 'like', '%' . $firstName . '%')
                ->orWhere('last_name', 'like', '%' . $firstName . '%')
                ->get();

            foreach ($studentsWithFirstName as $student) {
                // Check if any part of the user name matches the student name
                $studentFullName = strtolower($student->first_name . ' ' . $student->last_name);
                $userNameLower = strtolower($userName);

                // Simple substring match
                if (str_contains($studentFullName, $firstName) || str_contains($userNameLower, strtolower($student->first_name))) {
                    return $student;
                }
            }
        }

        return null;
    }
}
