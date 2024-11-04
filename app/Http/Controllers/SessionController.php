<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function store() {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($attributes)) {
            request()->session()->regenerate();
    
            // Redirect to the dashboard route
            return redirect()->route('dashboard');
        }

        // Redirect back with an error message if authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function destroy() {
        Auth::logout();
        return redirect()->route('home');
    }
}
