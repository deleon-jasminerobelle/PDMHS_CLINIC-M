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
        try {
            $user = Auth::user();
            
            // Debug logging
            \Log::info('Student Dashboard Access Attempt', [
                'user_id' => $user ? $user->id : 'null',
                'user_role' => $user ? $user->role : 'null',
                'user_name' => $user ? $user->name : 'null'
            ]);
            
            if (!$user) {
                \Log::warning('No authenticated user found');
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            
            // Ensure this is actually a student
            if ($user->role !== 'student') {
                \Log::warning('Non-student trying to access student dashboard', [
                    'user_role' => $user->role,
                    'user_id' => $user->id
                ]);
                return redirect()->route('login')->with('error', 'Access denied.');
            }
            
            \Log::info('Student dashboard access granted, loading view');
            
            // Use simplified data to avoid any potential issues
            $data = [
                'user' => $user,
                'student' => null,
                'lastVisit' => null,
                'latestVitals' => (object) ['weight' => '', 'height' => ''],
                'bmi' => '',
                'bmiCategory' => '',
                'bloodType' => '',
                'allergies' => collect(),
                'immunizations' => collect(),
                'age' => '',
                'recentVisits' => collect(),
                'totalVisits' => 0
            ];
            
            \Log::info('Student dashboard data prepared, rendering view');
            
            // Use safe view that handles all potential null values
            return view('student-dashboard-safe', $data);
            
        } catch (\Exception $e) {
            \Log::error('Student Dashboard Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    public function adviserDashboard()
    {
        try {
            $user = Auth::user();
            
            // Debug logging
            \Log::info('Adviser Dashboard Access Attempt', [
                'user_id' => $user ? $user->id : 'null',
                'user_role' => $user ? $user->role : 'null',
                'user_name' => $user ? $user->name : 'null'
            ]);
            
            if (!$user) {
                \Log::warning('No authenticated user found');
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            
            // Ensure this is actually an adviser
            if ($user->role !== 'adviser') {
                \Log::warning('Non-adviser trying to access adviser dashboard', [
                    'user_role' => $user->role,
                    'user_id' => $user->id
                ]);
                return redirect()->route('login')->with('error', 'Access denied.');
            }
            
            \Log::info('Adviser dashboard access granted, loading view');
            return $this->adviserDashboardView($user);
        } catch (\Exception $e) {
            \Log::error('Adviser Dashboard Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
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
            
            if (!$user) {
                \Log::warning('No authenticated user found');
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            
            // Ensure this is actually clinic staff
            if ($user->role !== 'clinic_staff') {
                \Log::warning('Non-clinic-staff trying to access clinic staff dashboard', [
                    'user_role' => $user->role,
                    'user_id' => $user->id
                ]);
                return redirect()->route('login')->with('error', 'Access denied. Clinic staff role required.');
            }
            
            \Log::info('Clinic staff dashboard access granted, loading view');
            return $this->clinicStaffDashboardView($user);
        } catch (\Exception $e) {
            \Log::error('Clinic Staff Dashboard Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    public function index()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            
            \Log::info('Dashboard Index - User Role Check', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name
            ]);
            
            // Redirect to appropriate dashboard based on role
            switch ($user->role) {
                case 'student':
                    \Log::info('Redirecting to student dashboard');
                    return redirect()->route('student.dashboard');
                case 'adviser':
                    \Log::info('Redirecting to adviser dashboard');
                    return redirect()->route('adviser.dashboard');
                case 'clinic_staff':
                    \Log::info('Redirecting to clinic staff dashboard');
                    return redirect()->route('clinic-staff.dashboard');
                case 'admin':
                    \Log::info('Loading admin dashboard');
                    // For admin, show generic dashboard
                    break;
                default:
                    \Log::warning('Unknown role detected', ['role' => $user->role]);
                    return redirect()->route('login')->with('error', 'Invalid user role.');
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
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    private function studentDashboardView($user)
    {
        try {
            \Log::info('Loading student dashboard view for user: ' . $user->name);
            
            // Initialize all required variables with safe default values
            $student = null;
            $latestVitals = (object) ['weight' => '', 'height' => ''];
            $bmi = '';
            $bmiCategory = '';
            $allergies = collect();
            $immunizations = collect();
            $totalVisits = 0;
            $recentVisits = collect();
            $lastVisit = null;
            $age = '';

            // Try to get student record by matching name (simplified approach)
            try {
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                
                $student = Student::where('first_name', $firstName)
                                 ->where('last_name', $lastName)
                                 ->first();
                
                if (!$student) {
                    // If exact match fails, try the first student for demo purposes
                    $student = Student::first();
                }
                
                if ($student) {
                    \Log::info('Student record found: ' . $student->first_name . ' ' . $student->last_name);
                    
                    // Calculate age if birth date exists
                    if ($student->date_of_birth) {
                        try {
                            $age = \Carbon\Carbon::parse($student->date_of_birth)->age;
                        } catch (\Exception $e) {
                            \Log::info('Age calculation failed: ' . $e->getMessage());
                            $age = '';
                        }
                    }
                } else {
                    \Log::info('No student record found, using default values');
                }
            } catch (\Exception $e) {
                \Log::error('Error finding student record: ' . $e->getMessage());
            }

            \Log::info('Student Dashboard Data Prepared Successfully', [
                'student_found' => $student ? true : false,
                'age' => $age,
                'total_visits' => $totalVisits,
                'allergies_count' => $allergies->count()
            ]);

            return view('student-dashboard', [
                'user' => $user,
                'student' => $student,
                'lastVisit' => $lastVisit,
                'latestVitals' => $latestVitals,
                'bmi' => $bmi,
                'bmiCategory' => $bmiCategory,
                'allergies' => $allergies,
                'immunizations' => $immunizations,
                'age' => $age,
                'recentVisits' => $recentVisits,
                'totalVisits' => $totalVisits
            ]);

        } catch (\Exception $e) {
            \Log::error('Student Dashboard View Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with minimal safe data
            return view('student-dashboard', [
                'user' => $user,
                'student' => null,
                'lastVisit' => null,
                'latestVitals' => (object) ['weight' => '', 'height' => ''],
                'bmi' => '',
                'bmiCategory' => '',
                'allergies' => collect(),
                'immunizations' => collect(),
                'age' => '',
                'recentVisits' => collect(),
                'totalVisits' => 0
            ]);
        }
    }

    private function adviserDashboardView($user)
    {
        try {
            // Get adviser record - if it doesn't exist, create basic data
            $adviser = Adviser::where('user_id', $user->id)->first();
            
            if (!$adviser) {
                \Log::info('No adviser record found, using basic data', ['user_id' => $user->id]);
                // Return with basic data if no adviser record exists
                return view('adviser-dashboard', [
                    'user' => $user,
                    'adviser' => null,
                    'students' => collect(),
                    'totalStudents' => 0,
                    'studentsWithAllergies' => 0,
                    'recentVisits' => collect(),
                    'pendingVisits' => 0
                ]);
            }

            // Get adviser's students
            $students = $adviser->students()->get();
            $totalStudents = $students->count();

            // Get students with allergies (placeholder - allergies table may not exist)
            $studentsWithAllergies = 0;

            // Get recent clinic visits for adviser's students (last 30 days)
            $studentIds = $students->pluck('id');
            $recentVisits = collect(); // Simplified for now
            
            try {
                if (class_exists('App\Models\ClinicVisit')) {
                    $recentVisits = \App\Models\ClinicVisit::whereIn('student_id', $studentIds)
                        ->where('visit_date', '>=', now()->subDays(30))
                        ->with(['student'])
                        ->orderBy('visit_date', 'desc')
                        ->get();
                }
            } catch (\Exception $e) {
                \Log::info('ClinicVisit model not available: ' . $e->getMessage());
            }

            // Get pending visits for adviser's students
            $pendingVisits = 0;
            try {
                if (class_exists('App\Models\ClinicVisit')) {
                    $pendingVisits = \App\Models\ClinicVisit::whereIn('student_id', $studentIds)
                        ->where('status', 'pending')
                        ->count();
                }
            } catch (\Exception $e) {
                \Log::info('Pending visits count not available: ' . $e->getMessage());
            }

            return view('adviser-dashboard', compact(
                'user',
                'adviser', 
                'students',
                'totalStudents',
                'studentsWithAllergies',
                'recentVisits',
                'pendingVisits'
            ));
        } catch (\Exception $e) {
            \Log::error('Adviser Dashboard View Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with safe default data
            return view('adviser-dashboard', [
                'user' => $user,
                'adviser' => null,
                'students' => collect(),
                'totalStudents' => 0,
                'studentsWithAllergies' => 0,
                'recentVisits' => collect(),
                'pendingVisits' => 0
            ]);
        }
    }

    private function clinicStaffDashboardView($user)
    {
        try {
            \Log::info('Loading clinic staff dashboard view');
            
            // For now, just return the clinic staff dashboard with basic data
            // In the future, this can be populated with actual health status data
            
            return view('clinic-staff-dashboard', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            \Log::error('Clinic Staff Dashboard View Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with safe default data
            return view('clinic-staff-dashboard', [
                'user' => $user
            ]);
        }
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