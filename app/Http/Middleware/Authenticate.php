<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function authenticated()
    {
        if (Auth::user()->user_type == 'Admin') {
            return redirect('dashboard');
        } else if (Auth::user()->user_type == 'Secretary') {
            return redirect('secretary/dashboard');
        } else if (Auth::user()->user_type == 'Staff') {
            return redirect('dashboard');
        } else {
            return redirect('/')->with('status', 'Login Successfully');
        }
    }
}

//..
