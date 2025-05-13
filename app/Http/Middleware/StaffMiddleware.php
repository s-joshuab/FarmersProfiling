<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user role is Staff (assuming 'user_type' field represents the role)
        if (Auth::check() && Auth::user()->user_type !== 'Staff') {
            return redirect('admin/dashboard')->with('status', 'Access Denied!');
        }

        return $next($request);
    }
}
