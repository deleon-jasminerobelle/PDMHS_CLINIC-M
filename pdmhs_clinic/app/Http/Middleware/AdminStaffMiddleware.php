<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminStaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isAdmin() && !auth()->user()->isClinicStaff() && !auth()->user()->isAdviser()) {
            return redirect()->route('student-health-form')->with('error', 'Access denied. Admin, clinic staff, or adviser only.');
        }

        return $next($request);
    }
}
