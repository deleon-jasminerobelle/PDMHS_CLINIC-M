<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if (!$user || !($user instanceof \App\Models\User) || ($user->role !== 'admin' && $user->role !== 'clinic_staff' && $user->role !== 'adviser')) {
            return redirect()->route('student-health-form')->with('error', 'Access denied. Admin, clinic staff, or adviser only.');
        }

        return $next($request);
    }
}
