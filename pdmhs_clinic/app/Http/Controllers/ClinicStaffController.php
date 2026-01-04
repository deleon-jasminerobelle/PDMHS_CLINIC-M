<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Student;
use App\Models\ClinicVisit;
use App\Traits\StudentHealthService;

class ClinicStaffController extends Controller
{
    use StudentHealthService;

    /**
     * Clinic Staff Dashboard
     */
    public function dashboard()
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Fetch recent clinic visits for dashboard
            $recentVisits = ClinicVisit::with('student')
                ->orderBy('visit_date', 'desc')
                ->limit(10)
                ->get();

            return view('clinic_staff.dashboard', compact('recentVisits'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to load dashboard.');
        }
    }

    /**
     * Store a new clinic visit
     */
    public function storeClinicVisit(Request $request, $studentId)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $student = Student::findOrFail($studentId);

            $validated = $request->validate([
                'visit_datetime' => 'required|date',
                'visit_type' => 'required|in:Routine Checkup,Emergency,Follow-up,Illness,Injury,Vaccination,Other',
                'chief_complaint' => 'required|string|max:1000',
                'weight' => 'nullable|numeric|min:0|max:500',
                'height' => 'nullable|numeric|min:0|max:300',
                'temperature' => 'nullable|numeric|min:30|max:50',
                'blood_pressure' => 'nullable|string|max:20',
                'notes' => 'nullable|string|max:2000',
                'requires_followup' => 'nullable|boolean'
            ]);

            $visit = new ClinicVisit([
                'student_id' => $student->id,
                'visit_date' => $validated['visit_datetime'],
                'visit_type' => $validated['visit_type'],
                'chief_complaint' => $validated['chief_complaint'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
                'staff_id' => $user->id,
                'requires_followup' => $validated['requires_followup'] ?? false
            ]);

            $visit->save();

            // Update student vitals if provided
            if ($validated['weight'] || $validated['height'] || $validated['temperature'] || $validated['blood_pressure']) {
                $student->update([
                    'weight' => $validated['weight'] ?? $student->weight,
                    'height' => $validated['height'] ?? $student->height,
                    'temperature' => $validated['temperature'] ?? $student->temperature,
                    'blood_pressure' => $validated['blood_pressure'] ?? $student->blood_pressure,
                ]);
            }

            return redirect()->route('clinic-staff.dashboard')->with('success', 'Clinic visit recorded successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Store Clinic Visit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error saving visit: ' . $e->getMessage())->withInput();
        }
    }
}
