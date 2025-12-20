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

class DashboardController extends Controller
{


    public function studentDashboard()
    {
        $user = Auth::user();
        
        // Debug logging
        \Log::info('Student Dashboard Access Attempt', [
            'user_id' => $user ? $user->id : 'null',
            'user_role' => $user ? $user->role : 'null',
            'user_name' => $user ? $user->name : 'null'
        ]);
        
        // Ensure this is actually a student
        if ($user->role !== 'student') {
            \Log::warning('Non-student trying to access student dashboard', [
                'user_role' => $user->role,
                'user_id' => $user->id
            ]);
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        
        return $this->studentDashboardView($user);
    }

    public function adviserDashboard()
    {
        $user = Auth::user();
        
        // Ensure this is actually an adviser
        if ($user->role !== 'adviser') {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        
        return $this->adviserDashboardView($user);
    }

    public function clinicStaffDashboard()
    {
        try {
            $user = Auth::user();
            
            // Debug logging
            \Log::info('Clinic Staff Dashboard Access Attempt', [
                'user_id' => $user ? $user->id : 'null',
                'user_role' => $user ? $user->role : 'null',
                'user_name' => $user ? $user->name : 'null'
            ]);
            
            // Ensure this is actually clinic staff
            if (!$user || $user->role !== 'clinic_staff') {
                \Log::warning('Non-clinic-staff trying to access clinic staff dashboard', [
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
            \Log::error('Clinic Staff Dashboard Error: ' . $e->getMessage());
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
            \Log::error('Dashboard Index Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    private function studentDashboardView($user)
    {
        try {
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
                    \Log::info('Age calculation failed: ' . $e->getMessage());
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
                \Log::info('Clinic visits not available: ' . $e->getMessage());
            }

            // Try to get allergies if the relationship exists
            try {
                if (method_exists($student, 'allergies')) {
                    $allergies = $student->allergies ?? collect();
                }
            } catch (\Exception $e) {
                \Log::info('Allergies not available: ' . $e->getMessage());
            }

            // Try to get immunizations if the relationship exists
            try {
                if (method_exists($student, 'immunizations')) {
                    $immunizations = $student->immunizations()
                        ->orderBy('date_administered', 'desc')
                        ->get();
                }
            } catch (\Exception $e) {
                \Log::info('Immunizations not available: ' . $e->getMessage());
            }

            \Log::info('Student Dashboard Data Prepared', [
                'student_id' => $student->id,
                'age' => $age,
                'total_visits' => $totalVisits,
                'allergies_count' => $allergies->count()
            ]);

            return view('student-dashboard-simple', compact(
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
                'totalVisits'
            ));

        } catch (\Exception $e) {
            \Log::error('Student Dashboard Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with minimal safe data
            return view('student-dashboard-simple', [
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
}