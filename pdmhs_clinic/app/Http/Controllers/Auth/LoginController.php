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

                        // Check if student has any health data stored before allowing dashboard access
                        if (!$this->studentHasAnyHealthData($user)) {
                            Log::info('Student login - no health data stored, redirecting to health form', [
                                'user_id' => $user->id,
                                'user_name' => $user->name
                            ]);
                            $request->session()->regenerate();
                            return redirect()->route('student-health-form')->with('info', 'Please complete your health information to access your dashboard.');
                        }

                        // Student has complete health data, allow dashboard access
                        $request->session()->regenerate();
                        return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
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
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            // If there's any error, still redirect to login
            return redirect()->route('login')->with('info', 'You have been logged out.');
        }
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
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
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
        // Use same parsing logic as HealthFormController
        [$firstName, $lastName] = array_pad(explode(' ', trim($user->name), 2), 2, '');

        if (empty($firstName) || empty($lastName)) {
            \Illuminate\Support\Facades\Log::info('Could not parse user name', [
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);
            return false;
        }

        // Try exact match first
        $student = \App\Models\Student::where('first_name', $firstName)
            ->where('last_name', $lastName)
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
        $student = \App\Models\Student::whereRaw('LOWER(first_name) = LOWER(?)', [$firstName])
            ->whereRaw('LOWER(last_name) = LOWER(?)', [$lastName])
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

        \Illuminate\Support\Facades\Log::info('Could not link user to student', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'parsed_first' => $firstName,
            'parsed_last' => $lastName
        ]);
        return false;
    }

    /**
     * Check if a student user has any health data stored in the students table
     */
    private function studentHasAnyHealthData($user)
    {
        \Illuminate\Support\Facades\Log::info('Checking student data for user', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_student_id' => $user->student_id
        ]);

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
                // Check if this linked student has any health data
                return $this->hasAnyHealthData($student);
            }

            \Illuminate\Support\Facades\Log::info('No student found by name for user', ['user_id' => $user->id, 'user_name' => $user->name]);
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
                // Check if this relinked student has any health data
                return $this->hasAnyHealthData($student);
            }

            \Illuminate\Support\Facades\Log::info('No student found by name as fallback', ['user_id' => $user->id, 'user_name' => $user->name]);
            return false;
        }

        \Illuminate\Support\Facades\Log::info('Found student for user', [
            'user_id' => $user->id,
            'student_id' => $student->id,
            'student_name' => $student->first_name . ' ' . $student->last_name
        ]);

        // Check if the student has any health data
        return $this->hasAnyHealthData($student);
    }

    /**
     * Check if a student has any health data stored (consistent with CheckHealthForm middleware)
     */
    private function hasAnyHealthData($student)
    {
        // Check for REQUIRED health data fields only (matches CheckHealthForm middleware)
        // Only check emergency contact fields as they are required
        $healthDataFields = [
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address'
        ];

        \Illuminate\Support\Facades\Log::info('Checking for any health data', [
            'student_id' => $student->id,
            'student_name' => $student->first_name . ' ' . $student->last_name
        ]);

        foreach ($healthDataFields as $field) {
            $value = $student->$field;

            // Handle different field types properly
            $hasValue = false;
            if ($value !== null) {
                if (is_array($value)) {
                    // For array fields (allergies, medical_conditions, medication, vaccination_history)
                    $hasValue = !empty($value);
                } else {
                    // For string/numeric fields
                    $hasValue = trim((string)$value) !== '';
                }
            }

            if ($hasValue) {
                \Illuminate\Support\Facades\Log::info('Student has health data', [
                    'student_id' => $student->id,
                    'field_with_data' => $field,
                    'field_value' => $value,
                    'student_name' => $student->first_name . ' ' . $student->last_name
                ]);
                return true;
            }
        }

        \Illuminate\Support\Facades\Log::info('Student has no health data stored', [
            'student_id' => $student->id,
            'student_name' => $student->first_name . ' ' . $student->last_name
        ]);
        return false;
    }

    /**
     * Find student by name with flexible matching
     */
    private function findStudentByName($userName)
    {
        $nameParts = array_filter(explode(' ', trim($userName)));

        if (empty($nameParts)) {
            return null;
        }

        // Strategy 1: Try to match by reconstructing the name
        // For names like "JASMINE ROBELLE ROBELLE CABARGA DE LEON"
        // Student record might have first_name = "JASMINE ROBELLE", last_name = "CABARGA DE LEON"

        for ($i = 1; $i < count($nameParts); $i++) {
            $possibleFirstName = implode(' ', array_slice($nameParts, 0, $i));
            $possibleLastName = implode(' ', array_slice($nameParts, $i));

            $student = \App\Models\Student::whereRaw('LOWER(first_name) = LOWER(?)', [$possibleFirstName])
                ->whereRaw('LOWER(last_name) = LOWER(?)', [$possibleLastName])
                ->first();

            if ($student) {
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
            return $student;
        }

        // Strategy 3: Try to find student where the user name contains the student name
        $allStudents = \App\Models\Student::all();
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