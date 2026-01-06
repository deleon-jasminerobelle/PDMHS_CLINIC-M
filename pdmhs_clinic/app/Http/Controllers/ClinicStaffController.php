<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\ClinicVisit;
use App\Traits\StudentHealthService;

class ClinicStaffController extends Controller
{
    use StudentHealthService;

    /**
     * Clinic Staff Dashboard
     */
    public function clinicDashboard()
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Fetch dashboard statistics
            $totalStudents = Student::count();
            $todayVisits = ClinicVisit::whereDate('visit_date', today())->count();
            $newVisits = ClinicVisit::where('status', 'pending')->count();
            $pendingVisits = ClinicVisit::where('follow_up_required', true)->count();

            // Fetch recent clinic visits for dashboard
            $recentVisits = ClinicVisit::with('student')
                ->orderBy('visit_date', 'desc')
                ->limit(10)
                ->get();

            // Fetch students with allergies
            $studentsWithAllergies = Student::whereNotNull('allergies')
                ->where('allergies', '!=', '')
                ->limit(5)
                ->get();

            return view('clinic-staff-dashboard', compact(
                'user',
                'totalStudents',
                'todayVisits',
                'newVisits',
                'pendingVisits',
                'recentVisits',
                'studentsWithAllergies'
            ));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to load dashboard.');
        }
    }

    /**
     * Clinic Staff Students Page
     */
    public function clinicStudents()
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            $students = Student::with('user')->paginate(20);

            return view('clinic-staff-students', compact('user', 'students'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Students Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.dashboard')->with('error', 'Unable to load students page.');
        }
    }

    /**
     * Clinic Staff Visits Page
     */
    public function clinicVisits()
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            $visits = ClinicVisit::with('student')->orderBy('visit_date', 'desc')->paginate(20);

            return view('clinic-staff-visits', compact('user', 'visits'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Visits Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.dashboard')->with('error', 'Unable to load visits page.');
        }
    }

    /**
     * Get Visit Details
     */
    public function getVisitDetails($visitId)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return response()->json(['error' => 'Access denied'], 403);
            }

            $visit = ClinicVisit::with('student')->findOrFail($visitId);

            return response()->json([
                'visit' => $visit,
                'student' => $visit->student
            ]);

        } catch (\Exception $e) {
            Log::error('Get Visit Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to load visit details'], 500);
        }
    }

    /**
     * Student Profile Page
     */
    public function studentProfile($id)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            $student = Student::with('user')->findOrFail($id);

            return view('clinic-staff-student-profile', compact('user', 'student'));

        } catch (\Exception $e) {
            Log::error('Student Profile Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.students')->with('error', 'Unable to load student profile.');
        }
    }

    /**
     * Add Student Visit
     */
    public function addStudentVisit(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $student = Student::findOrFail($id);

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

            return redirect()->route('clinic-staff.student.profile', $student->id)->with('success', 'Clinic visit recorded successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Add Student Visit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error saving visit: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Search Students
     */
    public function searchStudents(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return response()->json(['error' => 'Access denied'], 403);
            }

            $query = $request->get('q', '');
            $students = Student::where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('student_id', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            return response()->json($students);

        } catch (\Exception $e) {
            Log::error('Search Students Error: ' . $e->getMessage());
            return response()->json(['error' => 'Search failed'], 500);
        }
    }

    /**
     * Clinic Staff Profile
     */
    public function profile()
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            return view('clinic-staff-profile', compact('user'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Profile Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.dashboard')->with('error', 'Unable to load profile page.');
        }
    }

    /**
     * Update Clinic Staff Profile
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
            ]);

            $user->update($validated);

            return redirect()->back()->with('success', 'Profile updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Update Profile Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating profile.');
        }
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $validated = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->back()->with('success', 'Password updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Update Password Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating password.');
        }
    }

    /**
     * Upload Profile Picture
     */
    public function uploadProfilePicture(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profiles'), $filename);

                $user->update(['profile_picture' => $filename]);
            }

            return redirect()->back()->with('success', 'Profile picture updated successfully!');

        } catch (\Exception $e) {
            Log::error('Upload Profile Picture Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error uploading profile picture.');
        }
    }

    /**
     * Store a new clinic visit
     */
    public function storeVisit(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
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

            $student = Student::findOrFail($validated['student_id']);

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

            return redirect()->route('clinic-staff.visits')->with('success', 'Clinic visit recorded successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Store Visit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error saving visit: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Process QR Code Data
     */
    public function processQR(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->role !== 'clinic_staff') {
                return response()->json(['success' => false, 'message' => 'Access denied'], 403);
            }

            $validated = $request->validate([
                'qr_data' => 'required|string'
            ]);

            // Assuming QR data contains student ID
            $studentId = $validated['qr_data'];

            $student = Student::with('user')->where('student_id', $studentId)->first();

            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'student' => [
                    'id' => $student->id,
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'student_id' => $student->student_id,
                    'grade_level' => $student->grade_level,
                    'section' => $student->section
                ],
                'redirect_url' => route('clinic-staff.student-profile', $student->id)
            ]);

        } catch (\Exception $e) {
            Log::error('Process QR Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing QR code'
            ], 500);
        }
    }
}
