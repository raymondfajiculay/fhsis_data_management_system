<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RegisterController extends Controller
{
    public function index() {
        dd("test");
        if (Gate::allows('create-user')) {
            $municipalities = [
                'Aborlan',
                'Agutaya',
                'Araceli',
                'Bataraza',
                'Brooke’s Point',
                'Busuanga',
                'Cagayancillo',
                'Coron',
                'Dumaran',
                'El Nido',
                'Essig',
                'Kalayaan',
                'Narra',
                'Puerto Princesa',
                'Quezon',
                'Rizal',
                'San Vicente',
                'Sofronio Española',
                'Taytay'
            ];

            return view('auth.register', compact('municipalities'));
        } else {
            abort(403, 'Unauthorized');
        }
    }
    public function store(Request $request) {
        // dd(request()->all());
 
        $userData = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'municipality' => ['required'],
            'password' => ['required'],
        ]);

        $userData['role'] = Auth::user()->role === 'super_admin' ? 'admin' : 'user';
     
        try {
            // Store the user data in the database
            $user = User::create($userData);
    
            return redirect()->route('dashboard')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'There was an issue creating the user: ' . $e->getMessage()]);
        }
    }
    public function generatePassword()
    {
        $password = substr(bin2hex(random_bytes(4)), 0, 8); 
        return response()->json(['password' => $password]);
    }
    
}
