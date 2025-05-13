<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
 // Import the User model
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Spatie\Activitylog\Facades\Activity; // Import the Activity facade
date_default_timezone_set('Asia/Manila');
class AuthController extends Controller
{
    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            activity()
                ->causedBy(Auth::user())
                ->log('User logged in');

            if ($user->user_type === "Admin") {
                return redirect('dashboard');
            } elseif ($user->user_type === "Staff") {
                return redirect('dashboard');
            } elseif ($user->user_type === 'Secretary') {
            return redirect('farmdata');
            }

            // Log the login activity


        }

        return redirect()->route('login')->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        // Log the logout activity before logging the user out
        activity()
            ->causedBy(Auth::user())
            ->log('User logged out');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }



    public function forgotpassword()
    {
        return view('components.auth.forgot');
    }

    public function PostForgotPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            // Handle password reset logic
            // ...
            return redirect()->back()->with('success', 'Password reset instructions sent to your email.');

        } else {
            return redirect()->back()->with('error', 'Email Not Found in the System');
        }
    }


}
