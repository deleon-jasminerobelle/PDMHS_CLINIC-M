<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckHealthForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return $next($request);
            }
            if ($user->role === 'student') {
                // Check if user has student_id and if student exists in database
                if (!$user->student_id) {
                    return redirect()->route('student-health-form');
                }
                $student = \App\Models\Student::find($user->student_id);
                if (!$student) {
                    return redirect()->route('student-health-form');
                }
                // Store student_profile in session for later use
                $request->session()->put('student_profile', true);
            }
        }
        return $next($request);
    }
}
