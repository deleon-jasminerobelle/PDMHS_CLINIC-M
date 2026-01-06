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

            // Redirect to dashboard if already completed
            if ($student && $student->health_form_completed) {
                return redirect()->route('student.dashboard')
                    ->with('info', 'You have already completed your health form.');
            }
        }

        $advisers = Adviser::where('is_active', true)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('student-health-form', compact('student', 'advisers'));
    }

    public function store(Request $request)
    {
        Log::info('HealthFormController store called', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        // Debug LRN value
        Log::info('LRN from request', ['lrn' => $request->input('lrn')]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'lrn' => 'required|string|max:50',
            'school' => 'required|string|max:255',
            'grade_section' => ['required', 'string', 'max:50', 'regex:/^\d+\s*[A-Z]?$/'], // Allow optional space
            'birthday' => 'required|date',
            'gender' => 'required|in:M,F',
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
            'emergency_contact_number' => 'required|string|max:20',
            'medication' => 'nullable|array',
            'contact_number' => 'nullable|string|max:20',
            'parent_signature' => 'required|string|max:255',
            'signature_date' => 'required|date',
            'parent_relationship' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:20',
        ]);

        // Parse full name
        $nameParts = explode(' ', trim($request->name));
        $first = $nameParts[0] ?? '';
        $middle = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';
        $last = $nameParts[count($nameParts) - 1] ?? '';

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
        Log::info('Finding or creating student', ['lrn' => $request->lrn]);
        $student = Student::firstOrNew(['lrn' => $request->lrn]);
        Log::info('Student found/created', [
            'student_id' => $student->id,
            'exists' => $student->exists,
            'lrn' => $student->lrn
        ]);

        // Fill student data
        $student->first_name = $first;
        $student->middle_name = $middle;
        $student->last_name = $last;
        $student->date_of_birth = $request->birthday;
        $student->grade_level = $grade;
        $student->section = $section;
        $student->school = $request->school;
        $student->gender = $request->gender;
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
        $student->emergency_contact_number = $request->emergency_contact_number;
        $student->emergency_relation = $request->emergency_relation;
        $student->emergency_address = $request->emergency_address;
        $student->has_allergies = $request->has_allergies;
        $student->has_medical_condition = $request->has_medical_condition;
        $student->has_surgery = $request->has_surgery;
        $student->surgery_details = $request->surgery_details;

        // Calculate BMI
        if ($request->height && $request->weight && $request->height > 0) {
            $weight = floatval($request->weight);
            $height = floatval($request->height);

            if ($weight > 500) $weight = $weight / 1000;
            if ($height > 300) $height = $height / 10;

            $heightM = $height / 100;
            $bmi = round($weight / ($heightM * $heightM), 2);

            if ($bmi >= 10 && $bmi <= 50) {
                $student->bmi = $bmi;
                $student->weight = $weight;
                $student->height = $height;
            } else {
                $student->bmi = null;
            }
        }

        // Mark health form as completed
        $student->health_form_completed = true;

        // Save student
        Log::info('About to save student', [
            'student_id' => $student->id,
            'lrn' => $student->lrn,
            'health_form_completed' => $student->health_form_completed,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name
        ]);

        $studentSaveResult = $student->save();

        Log::info('Student save result', [
            'student_id' => $student->id,
            'save_result' => $studentSaveResult,
            'health_form_completed_after_save' => $student->health_form_completed
        ]);

        // Assign adviser if provided
        if ($request->adviser && trim($request->adviser)) {
            $this->assignAdviserToStudent($student, $request->adviser);
        }

        // Link student to user
        Log::info('Linking student to user', [
            'user_id' => $user->id,
            'student_id' => $student->id
        ]);
        $user->student_id = $student->id;
        $userSaveResult = $user->save();
        Log::info('User save result', [
            'user_id' => $user->id,
            'student_id' => $user->student_id,
            'save_result' => $userSaveResult
        ]);

        // Update session
        $request->session()->put('student_profile', true);

        Log::info('Student saved successfully', ['student_id' => $student->id, 'user_id' => $user->id]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Health form saved successfully. You can now access your dashboard.');
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

