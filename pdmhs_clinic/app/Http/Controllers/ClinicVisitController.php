<?php

namespace App\Http\Controllers;

use App\Models\ClinicVisit;
use App\Models\Student;
use Illuminate\Http\Request;

class ClinicVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clinicVisits = ClinicVisit::with('student')->get();
        return view('visits.index', compact('clinicVisits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('visits.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'visit_date' => 'required|date',
            'reason_for_visit' => 'required|string',
            'symptoms' => 'nullable|string',
            'status' => 'required|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medications' => 'nullable|string',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        ClinicVisit::create($request->all());

        return redirect()->route('visits.index')->with('success', 'Clinic visit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clinicVisit = ClinicVisit::with('student')->findOrFail($id);
        return view('visits.show', compact('clinicVisit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clinicVisit = ClinicVisit::findOrFail($id);
        $students = Student::all();
        return view('visits.edit', compact('clinicVisit', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'visit_date' => 'required|date',
            'reason_for_visit' => 'required|string',
            'symptoms' => 'nullable|string',
            'status' => 'required|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medications' => 'nullable|string',
            'follow_up_required' => 'boolean',
            'follow_up_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $clinicVisit = ClinicVisit::findOrFail($id);
        $clinicVisit->update($request->all());

        return redirect()->route('visits.index')->with('success', 'Clinic visit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clinicVisit = ClinicVisit::findOrFail($id);
        $clinicVisit->delete();

        return redirect()->route('visits.index')->with('success', 'Clinic visit deleted successfully.');
    }
}
