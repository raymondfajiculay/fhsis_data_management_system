<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function index() 
    {
        Gate::authorize('upload-file');

        // Set the range for years (e.g., 10 years from the current year)
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // Starting from 10 years ago
        $endYear = $currentYear + 10; // Ending 10 years into the future

        // Create an array of years
        $years = range($startYear, $endYear);

        return view('FileUpload.create' , compact('years'));
    }
    public function store()
    {  
        // Validate the file input
        request()->validate([
            'selected_months' => 'required|array',
            'report_year' => 'required|integer',
            'mdbFile' => 'required|mimes:mdb'
        ]);
    
        // Store the uploaded file in the storage directory
        if (request()->hasFile('mdbFile')) {
            $file = request()->file('mdbFile');
            $filename = time() . '-' . $file->getClientOriginalName();
    
            // Store the file in the storage/app/mdb folder
            $filePath = $file->storeAs('mdb', $filename);
    
            FileUpload::create([
                'user_id' => Auth::id(),
                'date_submitted' => now(),
                'selected_months' => json_encode(request()->input('selected_months', [])), 
                'report_year' => request()->report_year,
                'municipality' => Auth::user()->municipality,
                'file_path' => $filePath,
            ]);
    
            return redirect('/')->with('success', 'File uploaded successfully.');
        }
    
        return back()->withErrors('File upload failed.');
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

            if ($user->role === 'user') {
                $query->where('user_id', $user->id);
            } elseif ($user->role === 'admin') {
                $query->where('municipality', $user->municipality);
            }

           // Apply municipality filter if provided
            if (request()->has('municipality') && !empty(request()->municipality)) {
                $query->where('municipality', request()->municipality);
            }

            // Apply month filter if provided
            if (request()->has('month') && !empty(request()->month)) {
                $query->whereJsonContains('selected_months', request()->month);
            }

            // Apply year filter if provided
            if (request()->has('year') && !empty(request()->year)) {
                // dd("year");
                $query->where('report_year', request()->year);
            }

            // Execute the query with sorting
            $files = $query->orderBy('date_submitted', 'desc')->get();

            $selectedYear = old('year', request()->input('year', date('Y')));

            return view('FileUpload.show', compact('files', 'months', 'years', 'municipalities', 'selectedYear'));
        } else {
            return redirect()->route('home');
        }
    }

    public function download($id)
    {
        // Find the file upload by ID
        $fileUpload = FileUpload::findOrFail($id);

        // Get the file path
        $filePath = $fileUpload->file_path;

        // Check if the file exists
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return redirect()->back()->withErrors('File not found.');
    }

    public function destroy($id)
    {
        // Find the file upload by ID
        $fileUpload = FileUpload::findOrFail($id);

        // Get the file path
        $filePath = $fileUpload->file_path;

        // Check if the file exists and delete it
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Delete the record from the database
        $fileUpload->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
