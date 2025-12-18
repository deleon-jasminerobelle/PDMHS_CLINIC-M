<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HealthFormController extends Controller
{
    public function showForm()
    {
        return view('student-health-form');
    }

    public function submitForm(Request $request)
    {
        // Validate the form data if needed
        $request->validate([
            // Add validation rules here
        ]);

        // Set session flag indicating form is completed
        $request->session()->put('health_form_completed', true);

        // Redirect to login
        return redirect()->route('login');
    }
}
