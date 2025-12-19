<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try to authenticate with email (using username field as email)
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            if ($user->isAdmin() || $user->isClinicStaff()) {
                return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
            } elseif ($user->isAdviser()) {
                return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
            } elseif ($user->isStudent()) {
                return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
            } else {
                return redirect()->route('dashboard')->with('success', 'Welcome back!');
            }
<<<<<<< HEAD
            if ($user->role === 'student') {
                // Check if user has student_id and if student exists in database
                if ($user->student_id) {
                    $student = \App\Models\Student::where('student_id', $user->student_id)->first();
                    if ($student) {
                        // Store student_id in session for later use
                        $request->session()->put('student_id', $user->student_id);
                        return redirect()->route('student.dashboard');
                    }
                }
                return redirect()->route('student-health-form');
            }
            return redirect()->route('dashboard');
=======
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('username'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,clinic_staff,adviser,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route('students.index')->with('success', 'Registration successful!');
    }
}
