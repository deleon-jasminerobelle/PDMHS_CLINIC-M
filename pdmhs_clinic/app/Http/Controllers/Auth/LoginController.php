<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as Log;
use App\Models\User;
use App\Models\Student;
use App\Models\Adviser;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Check if user is already logged in with the same credentials
            if (Auth::check()) {
                $currentUser = Auth::user();
                if ($currentUser->email === $request->username) {
                    // User is already logged in with same credentials, redirect to appropriate dashboard
                    Log::info('User already logged in, redirecting to dashboard', [
                        'user_id' => $currentUser->id,
                        'email' => $currentUser->email,
                        'role' => $currentUser->role,
                        'session_id' => session()->getId()
                    ]);

                    switch ($currentUser->role) {
                        case 'student':
                            return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $currentUser->name . '!');
                        case 'adviser':
                            return redirect()->route('adviser.dashboard')->with('success', 'Welcome back, ' . $currentUser->name . '!');
                        case 'clinic_staff':
                            return redirect()->route('clinic-staff.dashboard')->with('success', 'Welcome back, ' . $currentUser->name . '!');
                        default:
                            return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $currentUser->name . '!');
                    }
                } else {
                    // Different user trying to login, logout current user first
                    Log::info('Different user logging in, clearing current session', [
                        'current_user' => $currentUser->email,
                        'new_user' => $request->username
                    ]);
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }
            }

            // Try to authenticate with email (using username field as email)
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
                // Refresh the user object to get updated student_id
                Auth::setUser(\App\Models\User::find(Auth::id()));
                // Regenerate session for security
                $request->session()->regenerate();
                $user = Auth::user();

                Log::info('User logged in successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                    'session_id' => session()->getId(),
                    'remember' => $request->filled('remember')
                ]);

                // Store additional session data for debugging
                session([
                    'login_time' => now()->toDateTimeString(),
                    'user_role' => $user->role,
                    'user_name' => $user->name,
                ]);

                // Redirect based on role to specific dashboard
                switch ($user->role) {
                    case 'student':
                        // Try to link user to existing student if not already linked
                        if (!$user->student_id) {
                            $this->linkUserToStudent($user);
                            // Refresh user object after potential linking
                            $user = \App\Models\User::find($user->id);
                        }

                        if ($this->studentHasData($user)) {
                            $request->session()->regenerate();
                            return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                        } else {
                            $request->session()->regenerate();
                            return redirect()->route('student-health-form')->with('info', 'Please complete your health form to access the dashboard.');
                        }
                        break;
                    case 'adviser':
                        $request->session()->regenerate();
                        return redirect()->route('adviser.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                        break;
                    case 'clinic_staff':
                        $request->session()->regenerate();
                        return redirect()->route('clinic-staff.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                        break;
                    default:
                        $request->session()->regenerate();
                        return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                        break;
                }
            }

            Log::warning('Failed login attempt', [
                'username' => $request->username,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('username'));

        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString(),
                'session_id' => session()->getId()
            ]);
            return back()->withErrors([
                'username' => 'An error occurred during login. Please try again.',
            ])->withInput($request->only('username'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,clinic_staff,adviser,student',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $name = $request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name;

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'student') {
            $student = Student::create([
                'student_id' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->birthday,
                'grade_level' => 1,
                'section' => 'A',
                'contact_number' => $request->contact_number,
                'emergency_contact_number' => $request->contact_number,
                'address' => $request->address,
                'sex' => $request->gender,
            ]);
            $user->update(['student_id' => $student->id]);
        } elseif ($request->role === 'adviser') {
            Adviser::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please log in with your credentials.');
    }

    /**
     * Try to link a user to an existing student record based on name matching
     */
    private function linkUserToStudent($user)
    {
        // Parse user name to find matching student
        $nameParts = explode(' ', trim($user->name));
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
                    $user->update(['student_id' => $student->id]);
                    \Illuminate\Support\Facades\Log::info('Linked user to existing student', [
                        'user_id' => $user->id,
                        'student_id' => $student->id,
                        'student_name' => $student->first_name . ' ' . $student->last_name,
                        'user_name' => $user->name
                    ]);
                    return true;
                }

                // Try case-insensitive match
                $student = \App\Models\Student::whereRaw('LOWER(first_name) LIKE LOWER(?)', [$firstName])
                    ->whereRaw('LOWER(last_name) LIKE LOWER(?)', [$lastName])
                    ->first();

                if ($student) {
                    $user->update(['student_id' => $student->id]);
                    \Illuminate\Support\Facades\Log::info('Linked user to existing student (case-insensitive)', [
                        'user_id' => $user->id,
                        'student_id' => $student->id,
                        'student_name' => $student->first_name . ' ' . $student->last_name,
                        'user_name' => $user->name
                    ]);
                    return true;
                }
            }

            // Try partial matching - search for any student containing the first name
            $studentsWithFirstName = \App\Models\Student::where('first_name', 'like', '%' . $firstName . '%')
                ->orWhere('last_name', 'like', '%' . $firstName . '%')
                ->get();

            foreach ($studentsWithFirstName as $student) {
                // Check if any part of the user name matches the student name
                $studentFullName = strtolower($student->first_name . ' ' . $student->last_name);
                $userNameLower = strtolower($user->name);

                // Simple substring match
                if (str_contains($studentFullName, $firstName) || str_contains($userNameLower, strtolower($student->first_name))) {
                    $user->update(['student_id' => $student->id]);
                    \Illuminate\Support\Facades\Log::info('Linked user to existing student (partial match)', [
                        'user_id' => $user->id,
                        'student_id' => $student->id,
                        'student_name' => $student->first_name . ' ' . $student->last_name,
                        'user_name' => $user->name
                    ]);
                    return true;
                }
            }
        }

        \Illuminate\Support\Facades\Log::info('Could not link user to student', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'name_parts' => $nameParts ?? []
        ]);
        return false;
    }

    /**
     * Check if a student user has complete health data in the students table
     */
    private function studentHasData($user)
    {
        if (!$user->student_id) {
            \Illuminate\Support\Facades\Log::info('User has no student_id, checking by name', ['user_id' => $user->id, 'user_name' => $user->name]);

            // Try to find student by name if no student_id
            $student = $this->findStudentByName($user->name);
            if ($student) {
                // Link the user to the student
                $user->update(['student_id' => $student->id]);
                \Illuminate\Support\Facades\Log::info('Linked user to student during data check', [
                    'user_id' => $user->id,
                    'student_id' => $student->id,
                    'student_name' => $student->first_name . ' ' . $student->last_name
                ]);
                // Check if this linked student has complete health data
                return $this->hasCompleteHealthData($student);
            }

            return false;
        }

        $student = \App\Models\Student::find($user->student_id);
        if (!$student) {
            \Illuminate\Support\Facades\Log::info('Student not found for user, trying name lookup', ['user_id' => $user->id, 'student_id' => $user->student_id]);

            // Try to find student by name as fallback
            $student = $this->findStudentByName($user->name);
            if ($student) {
                $user->update(['student_id' => $student->id]);
                \Illuminate\Support\Facades\Log::info('Relinked user to student during data check', [
                    'user_id' => $user->id,
                    'student_id' => $student->id,
                    'student_name' => $student->first_name . ' ' . $student->last_name
                ]);
                // Check if this relinked student has complete health data
                return $this->hasCompleteHealthData($student);
            }

            return false;
        }

        // Check if the student has complete health data
        return $this->hasCompleteHealthData($student);
    }

    /**
     * Check if a student has complete health data required for dashboard display
     */
    private function hasCompleteHealthData($student)
    {
        // Check for essential health data fields that should be filled by the health form
        $requiredFields = [
            'blood_type',
            'height',
            'weight',
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address'
        ];

        foreach ($requiredFields as $field) {
            if (empty($student->$field)) {
                \Illuminate\Support\Facades\Log::info('Student missing required health data', [
                    'student_id' => $student->id,
                    'missing_field' => $field,
                    'student_name' => $student->first_name . ' ' . $student->last_name
                ]);
                return false;
            }
        }

        \Illuminate\Support\Facades\Log::info('Student has complete health data', [
            'student_id' => $student->id,
            'student_name' => $student->first_name . ' ' . $student->last_name
        ]);
        return true;
    }

    /**
     * Find student by name with flexible matching (similar to DashboardController)
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
