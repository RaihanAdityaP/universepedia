<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // Default role
        ]);

        Auth::login($user);

        // Log registration activity
        ActivityLogger::log(
            action: 'register',
            description: 'New user registered: ' . $user->name,
            newValue: [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'registered_at' => now()->toDateTimeString(),
                'ip_address' => $request->ip(),
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }
}