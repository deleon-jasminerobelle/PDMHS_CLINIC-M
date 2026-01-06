<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckHealthForm
{
    public function handle(Request $request, Closure $next)
    {
        // Not logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // ✅ Allow health form routes (VERY IMPORTANT)
        if ($request->routeIs('student-health-form', 'student.health.store')) {
            return $next($request);
        }

        $user = Auth::user();

        // Only students are checked
        if ($user->role !== 'student') {
            return $next($request);
        }

        // Use relationship instead of find
        $student = $user->student ?? null;

        if (!$student) {
            Log::warning('No student record found', [
                'user_id' => $user->id,
            ]);

            return redirect()->route('student-health-form')
                ->with('info', 'Please complete your health form.');
        }

        // If health form is completed, allow access
        if ($student->health_form_completed) {
            return $next($request);
        }

        // If health form is not completed, redirect to form
        Log::info('Student blocked from dashboard (health form not completed)', [
            'student_id' => $student->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('student-health-form')
            ->with('info', 'Please complete your health form before accessing the dashboard.');
    }
}
