<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Student;
use App\Models\Adviser;

class HealthFormController extends Controller
{
    public function index()
    {
        $student = null;
        if (Auth::check() && Auth::user()->student_id) {
            $student = Student::find(Auth::user()->student_id);
        }

        return view('student-health-form', compact('student'));
    }

    public function store(Request $request)
    {
        Log::info('HealthFormController store called', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'lrn' => 'required|string|max:50',
            'school' => 'required|string|max:255',
            'grade_section' => ['required', 'string', 'max:50', 'regex:/^\d+\s*.*/'],
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'age' => 'required|integer|min:1',
            'adviser' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'temperature' => 'nullable|numeric|min:0',
            'blood_pressure' => 'nullable|string|max:20',
            'has_allergies' => 'nullable|in:0,1',
            'allergies' => 'nullable|array',
            'has_medical_condition' => 'nullable|in:0,1',
            'medical_conditions' => 'nullable|array',
            'has_surgery' => 'nullable|in:0,1',
            'surgery_details' => 'nullable|string|max:500',
            'family_history' => 'nullable|array',
            'smoke_exposure' => 'nullable|in:0,1',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_relation' => 'required|string|max:255',
            'emergency_address' => 'required|string|max:500',
            'emergency_phone' => 'required|string|max:20',
            'medication' => 'nullable|array',
            'contact_number' => 'nullable|string|max:20',
            'parent_signature' => 'required|string|max:255',
            'signature_date' => 'required|date',
            'parent_relationship' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:20',
        ]);

        [$first, $last] = array_pad(explode(' ', $request->name, 2), 2, '');

        // Parse grade_section
        $grade = null;
        $section = null;
        if (preg_match('/^(\d+)\s*(.*)$/', $request->grade_section, $matches)) {
            $grade = (int) $matches[1];
            $section = trim($matches[2]);
        }

        // Prepare vaccination history
        $vaccinationHistory = [];
        $vaccines = [
            'DP (Diptheria Pertussis)',
            'MMR (Measles, Mumps, Rubella)',
            'BCG (TB Vaccine)',
            'OPV (Oral Polio Vaccine)',
            'Rubella',
            'Chicken pox Vaccine',
            'Hepa B',
            'Tetanus',
            'Flu Vaccine',
            'Pneumococcal Vaccine',
            'MRTD Vaccine',
            'Hepa A',
            'Covid Vaccine',
            'Others'
        ];
        foreach ($vaccines as $vaccine) {
            $slug = Str::slug($vaccine);
            $vaccinationHistory[$slug] = [
                'given' => $request->input("vaccine_{$slug}", 'no'),
                'date' => $request->input("vaccine_date_{$slug}")
            ];
        }

        // Parent certification
        $parentCertification = [
            'signature' => $request->parent_signature,
            'date' => $request->signature_date,
            'relationship' => $request->parent_relationship,
            'contact' => $request->parent_contact,
        ];

        // Find or create student by LRN
        $student = Student::firstOrNew(['student_id' => $request->lrn]);

        // Fill student data
        $student->first_name = $first;
        $student->last_name = $last;
        $student->date_of_birth = $request->birthday;
        $student->grade_level = $grade;
        $student->section = $section;
        $student->school = $request->school;
        $student->gender = $request->sex;
        $student->age = $request->age;
        $student->adviser = $request->adviser;
        $student->blood_type = $request->blood_type;
        $student->height = $request->height;
        $student->weight = $request->weight;
        $student->temperature = $request->temperature;
        $student->blood_pressure = $request->blood_pressure;
        $student->allergies = $request->allergies;
        $student->medical_conditions = $request->medical_conditions;
        $student->family_history = $request->family_history;
        $student->smoke_exposure = $request->smoke_exposure;
        $student->medication = $request->medication;
        $student->parent_certification = $parentCertification;
        $student->vaccination_history = $vaccinationHistory;
        $student->emergency_contact_name = $request->emergency_contact_name;
        $student->emergency_contact_number = $request->emergency_phone;
        $student->emergency_relation = $request->emergency_relation;
        $student->emergency_address = $request->emergency_address;
        $student->has_allergies = $request->has_allergies;
        $student->has_medical_condition = $request->has_medical_condition;
        $student->has_surgery = $request->has_surgery;
        $student->surgery_details = $request->surgery_details;

        // Calculate BMI
        if ($request->height && $request->weight && $request->height > 0) {
            $heightM = $request->height / 100;
            $bmi = round($request->weight / ($heightM * $heightM), 2);
            $student->bmi = ($bmi >= 10 && $bmi <= 50) ? $bmi : null;
        }

        // Mark health form as completed
        $student->health_form_completed = true;

        $student->save(); // ✅ no more undefined method error

        // Assign adviser if provided
        if ($request->adviser && trim($request->adviser)) {
            $this->assignAdviserToStudent($student, $request->adviser);
        }

        // Link student to user if not already
        if (!Auth::user()->student_id) {
            Auth::user()->student_id = $student->id;
            Auth::user()->save();
        }

        // Update session flag
        $request->session()->put('student_profile', true);

        return redirect()->route('student.dashboard')
            ->with('success', 'Health form saved successfully.');
    }

    private function assignAdviserToStudent($student, $adviserName)
    {
        try {
            $adviserName = trim($adviserName);
            if (!$adviserName) return;

            $adviser = Adviser::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$adviserName])->first();

            if (!$adviser) {
                $parts = explode(' ', $adviserName);
                if (count($parts) >= 2) {
                    $firstName = $parts[0];
                    $lastName = implode(' ', array_slice($parts, 1));
                    $adviser = Adviser::where('first_name', 'like', "%{$firstName}%")
                        ->where('last_name', 'like', "%{$lastName}%")->first();
                }
            }

            if ($adviser) {
                $student->advisers()->syncWithoutDetaching([$adviser->id => ['assigned_date' => now()]]);
                Log::info('Adviser assigned', ['student_id' => $student->id, 'adviser_id' => $adviser->id]);
            }
        } catch (\Exception $e) {
            Log::error('Error assigning adviser: ' . $e->getMessage(), ['student_id' => $student->id]);
        }
    }
}

