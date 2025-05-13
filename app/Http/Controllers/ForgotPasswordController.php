<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('components.auth.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response === Password::RESET_LINK_SENT
            ? redirect()->back()->with('status', trans($response))
            : redirect()->back()->withErrors(['email' => trans($response)]);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('components.auth.reset', ['token' => $token, 'email' => $request->email]);
    }

   public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    $response = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    if ($response === Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('reset_success', 'Your password has been reset!');
    } else {
        return back()
            ->withInput($request->only('email'))
            ->with('reset_error', trans($response));
    }
}

}
