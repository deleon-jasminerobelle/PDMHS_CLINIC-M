<?php

namespace App\Http\Controllers;

use App\Models\HealthIncident;
use App\Models\Student;
use Illuminate\Http\Request;

class HealthIncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = HealthIncident::with('student')->paginate(10);
        return view('health_incidents.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('health_incidents.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'incident_date' => 'required|date',
            'incident_type' => 'required|string',
            'description' => 'required|string',
            'severity' => 'required|in:mild,moderate,severe',
            'location' => 'required|string',
            'reported_by' => 'required|string|max:255',
            'witnesses' => 'nullable|string',
            'first_aid_provided' => 'nullable|string',
            'medical_attention_required' => 'boolean',
            'follow_up_actions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        HealthIncident::create($request->all());

        return redirect()->route('health-incidents.index')->with('success', 'Health incident created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $healthIncident = HealthIncident::with('student')->findOrFail($id);
        return view('health_incidents.show', compact('healthIncident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $healthIncident = HealthIncident::findOrFail($id);
        $students = Student::all();
        return view('health_incidents.edit', compact('healthIncident', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'incident_date' => 'required|date',
            'incident_type' => 'required|string',
            'description' => 'required|string',
            'severity' => 'required|in:mild,moderate,severe',
            'location' => 'required|string',
            'reported_by' => 'required|string|max:255',
            'witnesses' => 'nullable|string',
            'first_aid_provided' => 'nullable|string',
            'medical_attention_required' => 'boolean',
            'follow_up_actions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $healthIncident = HealthIncident::findOrFail($id);
        $healthIncident->update($request->all());

        return redirect()->route('health-incidents.index')->with('success', 'Health incident updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $healthIncident = HealthIncident::findOrFail($id);
        $healthIncident->delete();

        return redirect()->route('health-incidents.index')->with('success', 'Health incident deleted successfully.');
    }
}
