<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrStaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the role 'Admin' or 'Staff'
        if (auth()->check() && (auth()->user()->user_type === 'Admin' || auth()->user()->user_type === 'Staff')) {
            return $next($request);
        }

        // Redirect to the custom 403 page if not admin or staff
        return response()->view('components.403', [], 403);
    }
}
