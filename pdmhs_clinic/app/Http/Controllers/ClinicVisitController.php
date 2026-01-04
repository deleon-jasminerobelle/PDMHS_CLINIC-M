<?php

namespace App\Http\Controllers;

use App\Models\ClinicVisit;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClinicVisitController extends Controller
{
    /**
     * Display a listing of the clinic visits.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $clinicVisits = ClinicVisit::with('student')->orderBy('visit_date', 'desc')->paginate(10);

        return view('visits.index', compact('clinicVisits'));
    }

    /**
     * Show the form for creating a new clinic visit.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $students = Student::all();
        return view('visits.create', compact('students'));
    }

    /**
     * Store a newly created clinic visit in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'visit_date' => 'required|date',
            'reason_for_visit' => 'required|string|max:1000',
            'symptoms' => 'nullable|string|max:1000',
            'status' => 'required|string|max:50',
            'diagnosis' => 'nullable|string|max:1000',
            'treatment' => 'nullable|string|max:1000',
            'medications' => 'nullable|string|max:500',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            ClinicVisit::create($validated);
            return redirect()->route('visits.index')->with('success', 'Clinic visit created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating clinic visit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create clinic visit.')->withInput();
        }
    }

    /**
     * Display the specified clinic visit.
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $clinicVisit = ClinicVisit::with('student')->findOrFail($id);
        return view('visits.show', compact('clinicVisit'));
    }

    /**
     * Show the form for editing the specified clinic visit.
     */
    public function edit($id)
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $clinicVisit = ClinicVisit::findOrFail($id);
        $students = Student::all();
        return view('visits.edit', compact('clinicVisit', 'students'));
    }

    /**
     * Update the specified clinic visit in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'visit_date' => 'required|date',
            'reason_for_visit' => 'required|string|max:1000',
            'symptoms' => 'nullable|string|max:1000',
            'status' => 'required|string|max:50',
            'diagnosis' => 'nullable|string|max:1000',
            'treatment' => 'nullable|string|max:1000',
            'medications' => 'nullable|string|max:500',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            $clinicVisit = ClinicVisit::findOrFail($id);
            $clinicVisit->update($validated);
            return redirect()->route('visits.index')->with('success', 'Clinic visit updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating clinic visit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update clinic visit.')->withInput();
        }
    }

    /**
     * Remove the specified clinic visit from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->role !== 'clinic_staff' && $user->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        try {
            $clinicVisit = ClinicVisit::findOrFail($id);
            $clinicVisit->delete();
            return redirect()->route('visits.index')->with('success', 'Clinic visit deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting clinic visit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete clinic visit.');
        }
    }
}
