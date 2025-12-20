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
                    \Log::info('User already logged in, redirecting to dashboard', [
                        'user_id' => $currentUser->id,
                        'email' => $currentUser->email,
                        'role' => $currentUser->role
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
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }
            }

            // Try to authenticate with email (using username field as email)
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
                // Only regenerate session for new logins, not for already authenticated users
                $request->session()->regenerate();
                $user = Auth::user();

                \Log::info('User logged in successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role
                ]);

                // Redirect based on role to specific dashboard
                switch ($user->role) {
                    case 'student':
                        return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                    case 'adviser':
                        return redirect()->route('adviser.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                    case 'clinic_staff':
                        return redirect()->route('clinic-staff.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                    default:
                        return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
                }
            }

            \Log::warning('Failed login attempt', [
                'username' => $request->username,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('username'));

        } catch (\Exception $e) {
            \Log::error('Login Error: ' . $e->getMessage());
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

        // Redirect based on role to specific dashboard
        switch ($user->role) {
            case 'student':
                return redirect()->route('student.dashboard')->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
            case 'adviser':
                return redirect()->route('adviser.dashboard')->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
            case 'clinic_staff':
                return redirect()->route('clinic-staff.dashboard')->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
            default:
                return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
        }
    }
}
