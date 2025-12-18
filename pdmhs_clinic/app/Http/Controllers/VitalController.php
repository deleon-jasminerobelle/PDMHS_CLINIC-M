<?php

namespace App\Http\Controllers;

use App\Models\Vital;
use App\Models\ClinicVisit;
use Illuminate\Http\Request;

class VitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vitals = Vital::with('clinicVisit.student')->paginate(10);
        return view('vitals.index', compact('vitals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinicVisits = ClinicVisit::with('student')->get();
        return view('vitals.create', compact('clinicVisits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clinic_visit_id' => 'required|exists:clinic_visits,id',
            'temperature' => 'nullable|numeric|min:0|max:50',
            'blood_pressure' => 'nullable|string|max:20',
            'heart_rate' => 'nullable|integer|min:0|max:300',
            'respiratory_rate' => 'nullable|integer|min:0|max:100',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'notes' => 'nullable|string',
        ]);

        Vital::create($request->all());

        return redirect()->route('vitals.index')->with('success', 'Vital signs recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vital = Vital::with('clinicVisit.student')->findOrFail($id);
        return view('vitals.show', compact('vital'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vital = Vital::findOrFail($id);
        $clinicVisits = ClinicVisit::with('student')->get();
        return view('vitals.edit', compact('vital', 'clinicVisits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'clinic_visit_id' => 'required|exists:clinic_visits,id',
            'temperature' => 'nullable|numeric|min:0|max:50',
            'blood_pressure' => 'nullable|string|max:20',
            'heart_rate' => 'nullable|integer|min:0|max:300',
            'respiratory_rate' => 'nullable|integer|min:0|max:100',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'notes' => 'nullable|string',
        ]);

        $vital = Vital::findOrFail($id);
        $vital->update($request->all());

        return redirect()->route('vitals.index')->with('success', 'Vital signs updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vital = Vital::findOrFail($id);
        $vital->delete();

        return redirect()->route('vitals.index')->with('success', 'Vital signs deleted successfully.');
    }
}
