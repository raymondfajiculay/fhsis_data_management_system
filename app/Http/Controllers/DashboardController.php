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
        return redirect()->route('login');
   }

   public function show() {
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
        $startYear = $currentYear - 20;
        $endYear = $currentYear;
        $years = range($startYear, $endYear);

        $query = FileUpload::query();

        // Role-based filtering
        if (Auth::check()) {
            $user = Auth::user();

            // Filter depending on user
            if ($user->role === 'user') {
                $query->where('user_id', $user->id);
            } elseif ($user->role === 'admin') {
                $query->where('municipality', $user->municipality);
            }

           // Apply year filter if provided; else use the current year
            $year = request()->has('year') && !empty(request()->year) ? request()->year : date('Y');
            $query->where('report_year', $year);

            // Set selectedYear to the requested year or the current year
            $selectedYear = old('year', request()->input('year', date('Y')));


            // Execute the query with sorting
            $files = $query->orderBy('date_submitted', 'desc')->get();

            return view('dashboard', compact('files', 'months', 'years', 'municipalities', 'selectedYear'));
        } else {
            return redirect()->route('home');
        }
    }
}
