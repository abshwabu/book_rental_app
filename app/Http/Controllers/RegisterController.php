<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'numeric|nullable',
            'location' => 'nullable|string|max:255'
        ]);

        // Create a new user and assign the default role as 'renter' or customize
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'renter',  // Default role is renter, or you can make this dynamic
            'location' => $request->location,
            'phone_number' => $request->phone_number,
        ]);

        Auth::login($user);

        return redirect()->intended('renter/dashboard')->with('status', 'Registration successful!');
    }
    

}
