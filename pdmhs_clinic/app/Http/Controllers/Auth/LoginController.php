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

            // Try to authenticate with email (using username field as email)
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
                $user = Auth::user();

                Log::info('User logged in successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role
                ]);

                // Redirect based on role to specific dashboard
                switch ($user->role) {
                    case 'student':
                        if (session('student_profile')) {
                            $request->session()->regenerate();
                            return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                        } else {
                            $request->session()->regenerate();
                            return redirect()->route('student-health-form')->with('info', 'Please complete your health form to access the dashboard.');
                        }
                    case 'adviser':
                        $request->session()->regenerate();
                        return redirect()->route('adviser.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                    case 'clinic_staff':
                        $request->session()->regenerate();
                        return redirect()->route('clinic-staff.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                    default:
                        $request->session()->regenerate();
                        return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                }
            }

            Log::warning('Failed login attempt', [
                'username' => $request->username,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('username'));

        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
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
}
