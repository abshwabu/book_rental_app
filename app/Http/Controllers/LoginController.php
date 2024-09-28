<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on the user's role for web-based login
            if ($request->expectsJson()) {
                // For API-based login, generate a token
                $user = Auth::user();
                $token = $user->createToken('access_token')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ]);
            } else {
                // Web-based login redirects based on role
                if (Auth::user()->role === 'owner') {
                    return redirect()->intended('owner/dashboard');
                } elseif (Auth::user()->role === 'renter') {
                    return redirect()->intended('renter/dashboard');
                } elseif (Auth::user()->role === 'admin') {
                    return redirect()->intended('admin/dashboard');
                }
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        // For web-based log out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutApi(Request $request)
    {
        // For API-based logout, revoke all tokens
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}

