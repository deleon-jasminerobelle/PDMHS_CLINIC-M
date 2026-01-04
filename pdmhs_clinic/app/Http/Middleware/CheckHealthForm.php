<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Student;

class CheckHealthForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Only apply this middleware to students
        if ($user->role !== 'student') {
            return $next($request);
        }

        // Get student record
        $student = Student::find($user->student_id);

        if (!$student) {
            Log::warning('No student record found for user', [
                'user_id' => $user->id,
                'user_name' => $user->name,
            ]);

            return redirect()->route('student-health-form')
                ->with('info', 'Please complete your health form before accessing your dashboard.');
        }

        // Check if emergency contact is filled out
        if (!$student->emergency_contact_name ||
            !$student->emergency_contact_number ||
            !$student->emergency_relation ||
            !$student->emergency_address) {
            Log::info('Student attempted to access dashboard without emergency contact', [
                'student_id' => $student->id,
                'user_id' => $user->id,
                'student_name' => $student->first_name . ' ' . $student->last_name,
                'emergency_contact_name' => $student->emergency_contact_name,
                'emergency_contact_number' => $student->emergency_contact_number,
                'emergency_relation' => $student->emergency_relation,
                'emergency_address' => $student->emergency_address
            ]);

            return redirect()->route('student-health-form')
                ->with('info', 'Please complete your health form before accessing your dashboard.');
        }

        return $next($request);
    }
}
