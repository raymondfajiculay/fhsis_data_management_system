<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('home');
   }

   public function show() {
        // dd(request()->all());
        $months = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];

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
        
        $currentYear = date("Y");
        $startYear = $currentYear - 10;
        $endYear = $currentYear + 10;
        $years = range($startYear, $endYear);

        $query = FileUpload::query();

        // Role-based filtering
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'user') {
                $query->where('user_id', $user->id);
            } elseif ($user->role === 'admin') {
                $query->where('municipality', $user->municipality);
            }

            // Apply month filter if provided
            if (request()->has('month') && !empty(request()->month)) {
                $query->whereJsonContains('selected_months', request()->month);
            }

            // Apply year filter if provided
            if (request()->has('year') && !empty(request()->year)) {
                $query->where('report_year', request()->year);
            }

            // Execute the query with sorting
            $files = $query->orderBy('date_submitted', 'desc')->get();

            return view('dashboard', compact('files', 'months', 'years', 'municipalities'));
        } else {
            return redirect()->route('home');
        }
    }
    public function showadmin() {
        $months = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];

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

        $files = FileUpload::all();
    
        return view('dashboard_admin', compact('files','months', 'municipalities'));
    }

}
