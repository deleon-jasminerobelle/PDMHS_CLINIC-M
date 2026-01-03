<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Student;
use App\Models\Adviser;

class HealthFormController extends Controller
{
    public function store(Request $request)
    {
        Log::info('HealthFormController store called', [
            'user_id' => Auth::id(),
            'student_id' => Auth::user()->student_id ?? null,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'lrn' => 'required|string|max:50',
            'school' => 'required|string|max:255',
            'grade_section' => [
                'required',
                'string',
                'max:50',
                'regex:/^\d+\s*.*/' // Must start with a number (grade level)
            ],
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

        // Parse grade_section with better validation
        $gradeSection = trim($request->grade_section);
        if (preg_match('/^(\d+)\s*(.*)$/', $gradeSection, $matches)) {
            $grade = (int) $matches[1];
            $section = trim($matches[2]);
        } else {
            // If no number found, treat the whole thing as section and default grade to null
            $grade = null;
            $section = $gradeSection;
        }

        // Log the parsed values for debugging
        Log::info('Parsed grade_section', [
            'original' => $request->grade_section,
            'grade' => $grade,
            'section' => $section
        ]);

        // Handle vaccination history
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
            $given = $request->input("vaccine_{$slug}", 'no'); // default to 'no' if not selected
            $date = $request->input("vaccine_date_{$slug}");
            $vaccinationHistory[$slug] = [
                'given' => $given,
                'date' => $date
            ];
        }

        // Handle parent certification
        $parentCertification = [
            'signature' => $request->parent_signature,
            'date' => $request->signature_date,
            'relationship' => $request->parent_relationship,
            'contact' => $request->parent_contact,
        ];

        if (!Auth::check()) {
            Log::error('User not authenticated');
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Find or create student record
        $student = null;
        if (Auth::user()->student_id) {
            $student = Student::find(Auth::user()->student_id);
        }

        // If no student found by user.student_id, try to find by LRN (student_id field)
        if (!$student) {
            $student = Student::where('student_id', $request->lrn)->first();
            if ($student) {
                Log::info('Found existing student by LRN', ['student_id' => $request->lrn, 'student_db_id' => $student->id]);
                // Update user's student_id if not set
                if (!Auth::user()->student_id) {
                    DB::table('users')->where('id', Auth::id())->update(['student_id' => $student->id]);
                    Log::info('Updated user student_id', ['user_id' => Auth::id(), 'student_id' => $student->id]);
                    // Refresh the authenticated user
                    Auth::setUser(\App\Models\User::find(Auth::id()));
                }
            }
        }

        if (!$student) {
            // Create new student record if it doesn't exist
            Log::info('Creating new student record', ['student_id' => $request->lrn]);
            $student = new Student();
        }

        $updateData = [
            'student_id' => $request->lrn,
            'first_name' => $first,
            'last_name' => $last,
            'date_of_birth' => $request->birthday,
            'grade_level' => $grade, // This should be an integer now
            'section' => $section,
            'school' => $request->school,
            'sex' => $request->sex,
            'age' => $request->age,
            'adviser' => $request->adviser,
            'blood_type' => $request->blood_type,
            'height' => $request->height,
            'weight' => $request->weight,
            'temperature' => $request->temperature,
            'blood_pressure' => $request->blood_pressure,
            'allergies' => $request->allergies ? json_encode($request->allergies) : null,
            'medical_conditions' => $request->medical_conditions ? json_encode($request->medical_conditions) : null,
            'family_history' => $request->family_history ? json_encode($request->family_history) : null,
            'smoke_exposure' => $request->smoke_exposure,
            'medication' => $request->medication ? json_encode($request->medication) : null,
            'parent_certification' => json_encode($parentCertification),
            'vaccination_history' => json_encode($vaccinationHistory),
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_phone,
            'emergency_relation' => $request->emergency_relation,
            'emergency_address' => $request->emergency_address,
            'has_allergies' => $request->has_allergies,
            'has_medical_condition' => $request->has_medical_condition,
            'has_surgery' => $request->has_surgery,
            'surgery_details' => $request->surgery_details,
        ];

        Log::info('Saving student with data', ['update_data' => $updateData]);

        // Use direct database operations to avoid model method issues
        if ($student->exists) {
            // Update existing student
            Log::info('Updating existing student', ['student_id' => $student->id, 'update_data' => $updateData]);
            $result = DB::table('students')->where('id', $student->id)->update($updateData);
            Log::info('Update result', ['result' => $result]);
        } else {
            // Create new student
            Log::info('Creating new student', ['update_data' => $updateData]);
            $studentId = DB::table('students')->insertGetId($updateData);
            Log::info('Create result', ['student_id' => $studentId]);

            // Update user's student_id if it wasn't set
            if (!Auth::user()->student_id) {
                DB::table('users')->where('id', Auth::id())->update(['student_id' => $studentId]);
                Log::info('Updated user student_id', ['user_id' => Auth::id(), 'student_id' => $studentId]);
                // Refresh the authenticated user to reflect the updated student_id
                Auth::setUser(\App\Models\User::find(Auth::id()));
                // Regenerate session to ensure updated user data is reflected
                $request->session()->regenerate();
            }
        }

        // Calculate BMI if height and weight are provided
        if ($request->height && $request->weight && $request->height > 0) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 2);

            // Validate BMI is within realistic range (10-50 for humans)
            if ($bmi >= 10 && $bmi <= 50) {
                // Update BMI using DB query to avoid model method issues
                DB::table('students')->where('id', $student->id)->update(['bmi' => $bmi]);
                Log::info('Updated BMI', ['student_id' => $student->id, 'bmi' => $bmi, 'height' => $request->height, 'weight' => $request->weight]);
            } else {
                Log::warning('Invalid BMI calculated, skipping update', [
                    'student_id' => $student->id,
                    'bmi' => $bmi,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'height_meters' => $heightInMeters
                ]);
                // Set BMI to null for invalid calculations
                DB::table('students')->where('id', $student->id)->update(['bmi' => null]);
            }
        }

        // Handle adviser assignment if adviser name is provided
        if ($request->adviser && !empty(trim($request->adviser))) {
            $this->assignAdviserToStudent($student, $request->adviser);
        }

        // Update session to indicate student profile is complete
        $request->session()->put('student_profile', true);

        return redirect()->route('student.dashboard')
            ->with('success', 'Health form saved successfully');
    }

    /**
     * Assign an adviser to a student based on adviser name
     */
    private function assignAdviserToStudent($student, $adviserName)
    {
        try {
            // Clean the adviser name
            $adviserName = trim($adviserName);

            if (empty($adviserName)) {
                return;
            }

            // Try to find adviser by full name match
            $adviser = Adviser::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$adviserName])->first();

            // If not found, try partial name matching
            if (!$adviser) {
                $nameParts = explode(' ', $adviserName);
                if (count($nameParts) >= 2) {
                    $firstName = $nameParts[0];
                    $lastName = implode(' ', array_slice($nameParts, 1));

                    $adviser = Adviser::where('first_name', 'like', "%{$firstName}%")
                                    ->where('last_name', 'like', "%{$lastName}%")
                                    ->first();
                }
            }

            // If adviser found, create the relationship
            if ($adviser) {
                // Check if relationship already exists
                $existingRelationship = DB::table('student_adviser')
                    ->where('student_id', $student->id)
                    ->where('adviser_id', $adviser->id)
                    ->first();

                if (!$existingRelationship) {
                    // Create the relationship
                    DB::table('student_adviser')->insert([
                        'student_id' => $student->id,
                        'adviser_id' => $adviser->id,
                        'assigned_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    Log::info('Adviser assigned to student', [
                        'student_id' => $student->id,
                        'adviser_id' => $adviser->id,
                        'adviser_name' => $adviserName
                    ]);
                }
            } else {
                Log::warning('Adviser not found for assignment', [
                    'student_id' => $student->id,
                    'adviser_name' => $adviserName
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error assigning adviser to student: ' . $e->getMessage(), [
                'student_id' => $student->id,
                'adviser_name' => $adviserName
            ]);
        }
    }
}
