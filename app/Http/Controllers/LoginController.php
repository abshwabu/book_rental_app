<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect to dashboard if login is successful
            return redirect()->intended('owner/dashboard')->with('status', 'Login successful!');
        }

        // Redirect back with error if login fails
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
