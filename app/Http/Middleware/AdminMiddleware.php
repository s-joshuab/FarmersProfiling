<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
{
    // Check if the user is authenticated and their role is either 'Admin' or 'Staff'
    if (!Auth::check() || !in_array(Auth::user()->user_type, ['Admin', 'Staff'])) {
        return redirect('admin/dashboard')->with('message', 'Access Denied!');
    }

    return $next($request);
}

}
