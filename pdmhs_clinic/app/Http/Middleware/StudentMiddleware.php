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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in to access this page.');
            }

            $user = Auth::user();

            if (!$user || !($user instanceof \App\Models\User) || $user->role !== 'student') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Access denied. Students only.');
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Student Middleware Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }
}
