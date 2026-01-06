<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in to access this page.');
            }

            $user = Auth::user();

            if (!$user || $user->role !== 'student') {
                if ($user) {
                    switch ($user->role) {
                        case 'adviser':
                            return redirect()->route('adviser.dashboard')->with('error', 'Access denied. Student role required.');
                        case 'clinic_staff':
                            return redirect()->route('clinic-staff.dashboard')->with('error', 'Access denied. Student role required.');
                        default:
                            Auth::logout();
                            return redirect()->route('login')->with('error', 'Access denied. Student role required.');
                    }
                } else {
                    return redirect()->route('login')->with('error', 'Please log in to access this page.');
                }
            }

            // User is student, allow access
            return $next($request);

        } catch (\Exception $e) {
            Log::error('StudentMiddleware Error: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString(),
                'session_id' => session()->getId(),
            ]);
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }
}
