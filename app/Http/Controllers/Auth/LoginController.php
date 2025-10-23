<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Log login activity
            ActivityLogger::log(
                action: 'login',
                description: 'User logged in successfully',
                newValue: [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_time' => now()->toDateTimeString(),
                ]
            );

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Log logout activity BEFORE logout
        ActivityLogger::log(
            action: 'logout',
            description: 'User logged out',
            oldValue: [
                'logout_time' => now()->toDateTimeString(),
            ]
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}