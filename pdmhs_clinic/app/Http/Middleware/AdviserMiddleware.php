<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdviserMiddleware
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
        try {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in to access this page.');
            }

            $user = Auth::user();
            
            if (!$user || $user->role !== 'adviser') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Access denied. Adviser role required.');
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Adviser Middleware Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }
}