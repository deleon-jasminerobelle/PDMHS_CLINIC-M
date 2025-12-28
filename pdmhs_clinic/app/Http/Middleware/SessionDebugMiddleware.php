<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SessionDebugMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Log session information before processing request
        Log::info('Session Debug - Before Request', [
            'session_id' => session()->getId(),
            'authenticated' => Auth::check(),
            'user_id' => Auth::check() ? Auth::id() : null,
            'user_role' => Auth::check() ? Auth::user()->role : null,
            'route' => $request->route() ? $request->route()->getName() : 'unknown',
            'url' => $request->url(),
            'method' => $request->method(),
            'session_data' => session()->all(),
        ]);

        $response = $next($request);

        // Log session information after processing request
        Log::info('Session Debug - After Request', [
            'session_id' => session()->getId(),
            'authenticated' => Auth::check(),
            'user_id' => Auth::check() ? Auth::id() : null,
            'response_status' => $response->getStatusCode(),
        ]);

        return $response;
    }
}