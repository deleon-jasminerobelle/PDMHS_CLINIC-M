<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ClinicVisit;
use App\Models\Immunization;
use App\Models\HealthIncident;
use App\Models\Allergy;
use App\Models\Adviser;
use App\Models\MedicalVisit;
use App\Models\Vitals;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class DashboardController extends Controller
{


    public function studentDashboard()
    {
        $user = Auth::user();
        
        // Debug logging
        Log::info('Student Dashboard Access Attempt', [
            'user_id' => $user ? $user->id : 'null',
            'user_role' => $user ? $user->role : 'null',
            'user_name' => $user ? $user->name : 'null'
        ]);
        
        // Ensure this is actually a student
        if (!$user || !($user instanceof \App\Models\User) || $user->role !== 'student') {
            Log::warning('Non-student trying to access student dashboard', [
                'user_role' => $user ? $user->role : 'null',
                'user_id' => $user ? $user->id : 'null'
            ]);
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        
        return $this->studentDashboardView($user);
    }

    public function adviserDashboard()
    {
        $user = Auth::user();
        
        // Ensure this is actually an adviser
        if (!$user || !($user instanceof \App\Models\User) || $user->role !== 'adviser') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        
        return $this->adviserDashboardView($user);
    }

    public function clinicStaffDashboard()
    {
        try {
            $user = Auth::user();
            
            // Debug logging
            Log::info('Clinic Staff Dashboard Access Attempt', [
                'user_id' => $user ? $user->id : 'null',
                'user_role' => $user ? $user->role : 'null',
                'user_name' => $user ? $user->name : 'null'
            ]);
            
            // Ensure this is actually clinic staff
            if (!$user || !($user instanceof \App\Models\User) || $user->role !== 'clinic_staff') {
                Log::warning('Non-clinic-staff trying to access clinic staff dashboard', [
                    'user_role' => $user ? $user->role : 'null',
                    'user_id' => $user ? $user->id : 'null'
                ]);
                Auth::logout();
                return redirect()->route('login')->with('error', 'Access denied. Please log in as clinic staff.');
            }
            
            // Regenerate session to prevent expiration issues
            request()->session()->regenerate();
            
            return $this->clinicStaffDashboardView($user);
        } catch (\Exception $e) {
            Log::error('Clinic Staff Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }
    }

    public function index()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            
            // Redirect to appropriate dashboard based on role
            if ($user instanceof \App\Models\User) {
                switch ($user->role) {
                    case 'student':
                        return redirect()->route('student.dashboard');
                    case 'adviser':
                        return redirect()->route('adviser.dashboard');
                    case 'clinic_staff':
                        return redirect()->route('clinic-staff.dashboard');
                    default:
                        // For admin or other roles, show generic dashboard
                        break;
                }
            }
            
            // Get dashboard statistics for admin (use generic dashboard)
            $stats = [
                'total_students' => Student::count(),
                'total_visits_today' => 0, // Simplified for now
                'pending_visits' => 0, // Simplified for now
                'total_immunizations' => 0, // Simplified for now
            ];

            $recent_visits = collect(); // Empty collection for now

            return view('dashboard', compact('user', 'stats', 'recent_visits'));
        } catch (\Exception $e) {
            Log::error('Dashboard Index Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    private function studentDashboardView($user)
    {
        try {
            // Get student record using the user's student_id
            $student = null;
            if ($user->student_id) {
                $student = Student::where('student_id', $user->student_id)->first();
            }

            if (!$student) {
                // If no student found by student_id, try matching by name as fallback
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';

                $student = Student::where('first_name', $firstName)
                                 ->where('last_name', $lastName)
                                 ->first();

                if (!$student) {
                    // If still no match, try the first student for demo purposes
                    $student = Student::first();
                    if (!$student) {
                        return redirect()->route('login')->with('error', 'No student records found.');
                    }
                }
            }

            // Initialize all required variables with default values
            $latestVitals = (object) ['weight' => 'N/A', 'height' => 'N/A'];
            $bmi = 'N/A';
            $bmiCategory = 'N/A';
            $allergies = collect();
            $immunizations = collect();
            $totalVisits = 0;
            $recentVisits = collect();
            $lastVisit = null;
            $age = null;

            // Calculate age if birth date exists
            if ($student->date_of_birth) {
                try {
                    $age = \Carbon\Carbon::parse($student->date_of_birth)->age;
                } catch (\Exception $e) {
                    Log::info('Age calculation failed: ' . $e->getMessage());
                    $age = 'N/A';
                }
            }

            // Try to get clinic visits if the relationship exists
            try {
                if (method_exists($student, 'clinicVisits')) {
                    $clinicVisits = $student->clinicVisits()
                        ->orderBy('visit_date', 'desc')
                        ->get();
                    $totalVisits = $clinicVisits->count();
                    $recentVisits = $clinicVisits->take(5);
                    $lastVisit = $clinicVisits->first();
                }
            } catch (\Exception $e) {
                Log::info('Clinic visits not available: ' . $e->getMessage());
            }

            // Try to get allergies if the relationship exists
            try {
                if (method_exists($student, 'allergies')) {
                    $allergies = $student->allergies ?? collect();
                }
            } catch (\Exception $e) {
                Log::info('Allergies not available: ' . $e->getMessage());
            }

            // Try to get immunizations if the relationship exists
            try {
                if (method_exists($student, 'immunizations')) {
                    $immunizations = $student->immunizations()
                        ->orderBy('date_administered', 'desc')
                        ->get();
                }
            } catch (\Exception $e) {
                Log::info('Immunizations not available: ' . $e->getMessage());
            }

            Log::info('Student Dashboard Data Prepared', [
                'student_id' => $student->id,
                'age' => $age,
                'total_visits' => $totalVisits,
                'allergies_count' => $allergies->count()
            ]);

            // Generate QR code for the student
            $qrData = json_encode([
                'student_id' => $student->student_id,
                'name' => $student->first_name . ' ' . $student->last_name,
                'grade_level' => $student->grade_level,
                'section' => $student->section,
                'school' => $student->school,
                'blood_type' => $student->blood_type,
                'emergency_contact' => $student->emergency_contact_name,
                'emergency_phone' => $student->emergency_contact_number,
                'timestamp' => now()->toISOString()
            ]);

            $renderer = new ImageRenderer(
                new RendererStyle(300, 4),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCode = $writer->writeString($qrData);

            return view('student-dashboard', compact(
                'user', 
                'student', 
                'lastVisit', 
                'latestVitals', 
                'bmi',
                'bmiCategory',
                'allergies', 
                'immunizations', 
                'age',
                'recentVisits',
                'totalVisits',
                'qrCode'
            ));

        } catch (\Exception $e) {
            Log::error('Student Dashboard Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with minimal safe data
            return view('student-dashboard', [
                'user' => $user,
                'student' => null,
                'lastVisit' => null,
                'latestVitals' => (object) ['weight' => 'N/A', 'height' => 'N/A'],
                'bmi' => 'N/A',
                'bmiCategory' => 'N/A',
                'allergies' => collect(),
                'immunizations' => collect(),
                'age' => 'N/A',
                'recentVisits' => collect(),
                'totalVisits' => 0
            ]);
        }
    }

    private function adviserDashboardView($user)
    {
        // Get adviser record
        $adviser = Adviser::where('user_id', $user->id)->first();
        
        if (!$adviser) {
            return redirect()->route('login')->with('error', 'Adviser record not found.');
        }

        // Get adviser's students
        $students = $adviser->students()->get();
        $totalStudents = $students->count();

        // Get students with allergies (placeholder - allergies table may not exist)
        $studentsWithAllergies = 0;

        // Get recent clinic visits for adviser's students (last 30 days)
        $studentIds = $students->pluck('id');
        $recentVisits = ClinicVisit::whereIn('student_id', $studentIds)
            ->where('visit_date', '>=', now()->subDays(30))
            ->with(['student'])
            ->orderBy('visit_date', 'desc')
            ->get();

        // Get pending visits for adviser's students
        $pendingVisits = ClinicVisit::whereIn('student_id', $studentIds)
            ->where('status', 'pending')
            ->count();

        return view('adviser-dashboard', compact(
            'user',
            'adviser', 
            'students',
            'totalStudents',
            'studentsWithAllergies',
            'recentVisits',
            'pendingVisits'
        ));
    }

    private function clinicStaffDashboardView($user)
    {
        // For now, just return the clinic staff dashboard with empty data
        // In the future, this can be populated with actual health status data
        
        return view('clinic-staff-dashboard', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();

        if (!$user || !($user instanceof \App\Models\User)) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Get student record using the user-student relationship
        $student = null;
        if ($user->student_id) {
            $student = Student::where('student_id', $user->student_id)->first();
        }

        if (!$student) {
            return redirect()->route('student-health-form')->with('info', 'Please complete your health form first.');
        }

        return view('student-profile', compact('user', 'student'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Get student record by matching name (temporary solution)
        $nameParts = explode(' ', $user->name);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
        
        $student = Student::where('first_name', $firstName)
                         ->where('last_name', $lastName)
                         ->first();
        
        if (!$student) {
            // If exact match fails, try the first student for demo purposes
            $student = Student::first();
            if (!$student) {
                return redirect()->route('login')->with('error', 'No student records found.');
            }
        }

        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:80',
            'middle_name' => 'nullable|string|max:80',
            'last_name' => 'required|string|max:80',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:M,F,Other',
            'grade_level' => 'nullable|string|max:20',
            'section' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:150',
        ]);

        // Update the student record
        $student->update($validated);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    public function generateQrCode()
    {
        $user = Auth::user();

        if (!$user || !($user instanceof \App\Models\User) || $user->role !== 'student') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        // Get student record
        $student = null;
        if ($user->student_id) {
            $student = Student::where('student_id', $user->student_id)->first();
        }

        if (!$student) {
            // Fallback to name matching
            $nameParts = explode(' ', $user->name);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            $student = Student::where('first_name', $firstName)
                             ->where('last_name', $lastName)
                             ->first();
        }

        if (!$student) {
            return response()->json(['error' => 'Student record not found'], 404);
        }

        // Create QR code data containing student information
        $qrData = json_encode([
            'student_id' => $student->student_id,
            'name' => $student->first_name . ' ' . $student->last_name,
            'grade_level' => $student->grade_level,
            'section' => $student->section,
            'school' => $student->school,
            'blood_type' => $student->blood_type,
            'emergency_contact' => $student->emergency_contact_name,
            'emergency_phone' => $student->emergency_contact_number,
            'timestamp' => now()->toISOString()
        ]);

        // Generate QR code
        $renderer = new ImageRenderer(
            new RendererStyle(400, 4),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($qrData);

        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}
