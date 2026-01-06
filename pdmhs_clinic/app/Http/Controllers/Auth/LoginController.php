<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Student;
use App\Models\Adviser;
use Carbon\Carbon;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|string|in:student,adviser,clinic_staff'
        ]);

        $role = $request->input('role');

        $user = User::where('email', $request->username)
                    ->where('role', $role)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['username' => 'Invalid credentials for this role.'])
                         ->withInput($request->only('username', 'role'));
        }

        Auth::login($user);
        $request->session()->regenerate();

        switch ($role) {
            case 'student':
                if (!$this->studentHasAnyHealthData($user)) {
                    return redirect()->route('student-health-form')
                                     ->with('info', 'Please complete your health information.');
                }
                return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
            case 'adviser':
                return redirect()->route('adviser.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
            case 'clinic_staff':
                return redirect()->route('clinic-staff.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:500',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,clinic_staff,adviser'
        ]);

        try {
            $role = $request->input('role');

            if ($role === 'student') {
                // Create student record first
                $student = Student::create([

                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name ?: null,
                    'last_name' => $request->last_name,
                    'date_of_birth' => $request->birthday,
                    'gender' => $request->gender,
                    'contact_number' => $request->contact_number,
                    'address' => $request->address,
                    'age' => Carbon::parse($request->birthday)->age,
                    'student_id' => 'STU'.time(),
                ]);

                // Create user linked to student
                $user = User::create([
                    'name' => $request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $role,
                    'student_id' => $student->id,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name ?: null,
                    'last_name' => $request->last_name,
                    'birthday' => $request->birthday,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'contact_number' => $request->contact_number,
                ]);

                Log::info("New student registered: {$user->name} (ID: {$user->id})");

            } else {
                // For clinic_staff or adviser
                $user = User::create([
                    'name' => $request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $role,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name ?: null,
                    'last_name' => $request->last_name,
                    'birthday' => $request->birthday,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'contact_number' => $request->contact_number,
                ]);

                Log::info("New {$role} registered: {$user->name} (ID: {$user->id})");
            }

            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');

        } catch (\Exception $e) {
            Log::error('Registration failed', ['exception' => $e]);
            return back()->withErrors(['registration' => 'Registration failed. Please check your details and try again.'])->withInput();
        }
    }

    private function studentHasAnyHealthData($user)
    {
        if (!$user->student_id) return false;

        $student = Student::find($user->student_id);
        if (!$student) return false;

        $requiredFields = [
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address'
        ];

        foreach ($requiredFields as $field) {
            if (!empty($student->$field)) return true;
        }

        return false;
    }
}
