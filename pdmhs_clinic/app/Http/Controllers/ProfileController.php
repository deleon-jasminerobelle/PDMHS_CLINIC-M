<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile page
     */
    public function show()
    {
        $user = Auth::user();
        
        // Load adviser information if user is an adviser
        if ($user->isAdviser()) {
            $user->load('adviser');
        }
        
        return view('profile.show', compact('user'));
    }

    /**
     * Update the profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:500',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'name' => $request->first_name . ' ' . $request->last_name, // Update full name
        ]);

        return redirect()->route('adviser.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('adviser.profile')->with('success', 'Password updated successfully!');
    }
}