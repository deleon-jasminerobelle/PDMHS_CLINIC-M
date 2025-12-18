<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use App\Models\Student;
use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $immunizations = Immunization::with('student')->get();
        return view('immunization.index', compact('immunizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('immunization.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'vaccine_name' => 'required|string',
            'date_administered' => 'required|date',
            'next_due_date' => 'nullable|date',
            'administered_by' => 'nullable|string',
            'batch_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Immunization::create($request->all());

        return redirect()->route('immunizations.index')->with('success', 'Immunization record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $immunization = Immunization::with('student')->findOrFail($id);
        return view('immunization.show', compact('immunization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $immunization = Immunization::findOrFail($id);
        $students = Student::all();
        return view('immunization.edit', compact('immunization', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'vaccine_name' => 'required|string',
            'date_administered' => 'required|date',
            'next_due_date' => 'nullable|date',
            'administered_by' => 'nullable|string',
            'batch_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $immunization = Immunization::findOrFail($id);
        $immunization->update($request->all());

        return redirect()->route('immunizations.index')->with('success', 'Immunization record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $immunization = Immunization::findOrFail($id);
        $immunization->delete();

        return redirect()->route('immunizations.index')->with('success', 'Immunization record deleted successfully.');
    }
}
