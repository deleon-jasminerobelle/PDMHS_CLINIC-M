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
}
