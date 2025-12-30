<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
            // Check authentication first
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }

            $user = Auth::user();

            // Ensure this is actually a student
            if ($user->role !== 'student') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Get student record using the student_id relationship
            $student = null;
            if ($user->student_id) {
                $student = Student::find($user->student_id);
            }

            // Fallback: try to find student by name matching if no direct relationship
            if (!$student) {
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';

                $student = Student::where('first_name', $firstName)
                                 ->where('last_name', $lastName)
                                 ->first();
            }

            // Initialize default values
            $latestVitals = (object) ['weight' => '', 'height' => '', 'temperature' => '', 'blood_pressure' => ''];
            $bmi = '';
            $bmiCategory = '';
            $age = '';
            $allergies = collect();
            $immunizations = collect();
            $healthIncidents = collect();
            $medicalVisits = collect();
            $recentVisits = collect();
            $totalVisits = 0;
            $lastVisit = null;

            if ($student) {
                // Calculate age if birth date exists
                if ($student->date_of_birth) {
                    try {
                        $age = Carbon::parse($student->date_of_birth)->age;
                    } catch (\Exception $e) {
                        $age = '';
                    }
                }

                // Get latest vitals - try from Vitals table first, then fallback to student data
                try {
                    $latestVital = Vitals::whereHas('clinicVisit', function($query) use ($student) {
                        $query->where('student_id', $student->id);
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                    if ($latestVital) {
                        $latestVitals = (object) [
                            'weight' => $latestVital->weight ?? '',
                            'height' => $latestVital->height ?? '',
                            'temperature' => $latestVital->temperature ?? '',
                            'blood_pressure' => $latestVital->blood_pressure ?? '',
                            'heart_rate' => $latestVital->heart_rate ?? '',
                            'respiratory_rate' => $latestVital->respiratory_rate ?? ''
                        ];
                    } else {
                        // Fallback to student table data
                        $latestVitals = (object) [
                            'weight' => $student->weight ?? '',
                            'height' => $student->height ?? '',
                            'temperature' => $student->temperature ?? '',
                            'blood_pressure' => $student->blood_pressure ?? '',
                        ];
                    }

                    // Calculate BMI if both weight and height are available
                    $weight = $latestVitals->weight ?: $student->weight;
                    $height = $latestVitals->height ?: $student->height;

                    if ($weight && $height && $height > 0) {
                        $heightInMeters = $height / 100;
                        $bmiValue = $weight / ($heightInMeters * $heightInMeters);
                        $bmi = number_format($bmiValue, 1);

                        // Determine BMI category
                        if ($bmiValue < 18.5) {
                            $bmiCategory = 'Underweight';
                        } elseif ($bmiValue < 25) {
                            $bmiCategory = 'Normal';
                        } elseif ($bmiValue < 30) {
                            $bmiCategory = 'Overweight';
                        } else {
                            $bmiCategory = 'Obese';
                        }
                    }
                } catch (\Exception $e) {
                    Log::info('Error fetching vitals: ' . $e->getMessage());
                    // Fallback to student data
                    $latestVitals = (object) [
                        'weight' => $student->weight ?? '',
                        'height' => $student->height ?? '',
                        'temperature' => $student->temperature ?? '',
                        'blood_pressure' => $student->blood_pressure ?? '',
                    ];
                }

                // Get allergies - try from Allergy table first, then from student JSON field
                try {
                    $allergiesFromTable = Allergy::where('student_id', $student->id)->get();
                    if ($allergiesFromTable->count() > 0) {
                        $allergies = $allergiesFromTable;
                    } else {
                        // Fallback to JSON field in student table
                        $studentAllergies = $student->allergies;
                        if (is_array($studentAllergies) && count($studentAllergies) > 0) {
                            $allergies = collect($studentAllergies)->map(function($allergy) {
                                return (object) [
                                    'allergy_name' => is_string($allergy) ? $allergy : ($allergy['name'] ?? 'Unknown'),
                                    'severity' => $allergy['severity'] ?? 'Unknown'
                                ];
                            });
                        }
                    }
                } catch (\Exception $e) {
                    Log::info('Error fetching allergies: ' . $e->getMessage());
                }

                // Get immunizations
                try {
                    $immunizations = Immunization::where('student_id', $student->id)->get();
                } catch (\Exception $e) {
                    Log::info('Error fetching immunizations: ' . $e->getMessage());
                }

                // Get health incidents
                try {
                    $healthIncidents = HealthIncident::where('student_id', $student->id)
                                                   ->orderBy('incident_date', 'desc')
                                                   ->limit(5)
                                                   ->get();
                } catch (\Exception $e) {
                    Log::info('Error fetching health incidents: ' . $e->getMessage());
                }

                // Get medical visits
                try {
                    $medicalVisits = MedicalVisit::where('student_id', $student->id)
                                               ->orderBy('visit_datetime', 'desc')
                                               ->limit(10)
                                               ->get();
                } catch (\Exception $e) {
                    Log::info('Error fetching medical visits: ' . $e->getMessage());
                }

                // Get recent visits
                try {
                    $recentVisits = ClinicVisit::where('student_id', $student->id)
                                              ->orderBy('visit_date', 'desc')
                                              ->limit(5)
                                              ->get();
                    $totalVisits = ClinicVisit::where('student_id', $student->id)->count();
                    $lastVisit = $recentVisits->first();
                } catch (\Exception $e) {
                    Log::info('Error fetching visits: ' . $e->getMessage());
                }
            }

            $data = [
                'user' => $user,
                'student' => $student,
                'lastVisit' => $lastVisit,
                'latestVitals' => $latestVitals,
                'bmi' => $bmi,
                'bmiCategory' => $bmiCategory,
                'bloodType' => $student->blood_type ?? '',
                'allergies' => $allergies,
                'immunizations' => $immunizations,
                'age' => $age,
                'recentVisits' => $recentVisits,
                'totalVisits' => $totalVisits,
                'healthIncidents' => $healthIncidents,
                'medicalVisits' => $medicalVisits
            ];

            return view('student-dashboard', $data);

        } catch (\Exception $e) {
            Log::error('Student Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    public function studentMedical()
    {
        try {
            // Check authentication first
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }

            $user = Auth::user();
            
            if ($user->role !== 'student') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }
            
            // Get basic medical data (simplified for now)
            $data = [
                'user' => $user,
                'totalVisits' => 2, // Placeholder data
                'recentVisits' => 1, // Placeholder data
                'allergies' => collect(['Peanuts', 'Shellfish']), // Placeholder data
            ];
            
            return view('student-medical', $data);
            
        } catch (\Exception $e) {
            Log::error('Student Medical Page Error: ' . $e->getMessage());
            return redirect()->route('student.dashboard')->with('error', 'An error occurred loading medical records.');
        }
    }

    public function studentInfo()
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'student') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }
            
            // Get student record by matching name (simplified approach)
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
            
            // Calculate age if birth date exists
            $age = '';
            if ($student && $student->date_of_birth) {
                try {
                    $age = \Carbon\Carbon::parse($student->date_of_birth)->age;
                } catch (\Exception $e) {
                    $age = '20'; // Default age
                }
            }
            
            // Get adviser information dynamically
            $adviser = null;
            if ($student && $student->adviser) {
                // Try to find adviser by name matching
                $adviser = Adviser::where('first_name', 'like', '%' . explode(' ', $student->adviser)[0] . '%')
                                 ->orWhere('last_name', 'like', '%' . end(explode(' ', $student->adviser)) . '%')
                                 ->first();

                // If no adviser found, create a simple object with the name
                if (!$adviser) {
                    $adviser = (object) ['name' => $student->adviser];
                }
            } else {
                // Fallback: try to find adviser by student's grade/section if no direct adviser field
                if ($student && ($student->grade_level || $student->section)) {
                    $adviser = Adviser::whereHas('students', function($query) use ($student) {
                        $query->where('grade_level', $student->grade_level)
                              ->where('section', $student->section);
                    })->first();
                }
            }

            $data = [
                'user' => $user,
                'student' => $student,
                'age' => $age,
                'adviser' => $adviser,
            ];
            
            return view('student-info', $data);
            
        } catch (\Exception $e) {
            Log::error('Student Info Page Error: ' . $e->getMessage());
            return redirect()->route('student.dashboard')->with('error', 'An error occurred loading student information.');
        }
    }

    public function studentMedicalHistory()
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'student') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }
            
            // Sample medical visits data (replace with actual database queries later)
            $visits = [
                [
                    'date' => 'December 15, 2024',
                    'time' => '10:30 AM',
                    'status' => 'Completed',
                    'type' => 'Regular Checkup',
                    'attendedBy' => 'Nurse Maria Santos',
                    'temperature' => '36.5°C',
                    'bloodPressure' => '120/80 mmHg',
                    'weight' => '55 kg',
                    'height' => '165 cm',
                    'reason' => 'Annual health screening and general wellness check.'
                ],
                [
                    'date' => 'November 28, 2024',
                    'time' => '2:15 PM',
                    'status' => 'Completed',
                    'type' => 'Illness',
                    'attendedBy' => 'Dr. Juan Dela Cruz',
                    'temperature' => '38.2°C',
                    'bloodPressure' => '125/85 mmHg',
                    'weight' => '54 kg',
                    'height' => '165 cm',
                    'reason' => 'Student complained of fever, headache, and body aches. Diagnosed with viral infection. Prescribed rest and medication.'
                ],
                [
                    'date' => 'October 10, 2024',
                    'time' => '11:45 AM',
                    'status' => 'Completed',
                    'type' => 'Injury',
                    'attendedBy' => 'Nurse Ana Rodriguez',
                    'temperature' => '36.8°C',
                    'bloodPressure' => '118/75 mmHg',
                    'weight' => '54 kg',
                    'height' => '165 cm',
                    'reason' => 'Minor cut on left hand from PE class. Wound cleaned and bandaged. Tetanus shot administered.'
                ]
            ];
            
            $data = [
                'user' => $user,
                'visits' => $visits,
            ];
            
            return view('student-medical-history', $data);
            
        } catch (\Exception $e) {
            Log::error('Student Medical History Page Error: ' . $e->getMessage());
            return redirect()->route('student.medical')->with('error', 'An error occurred loading medical history.');
        }
    }

    public function adviserDashboard()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            
            // Ensure this is actually an adviser
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }
            
            // Get notifications for this adviser
            $notifications = \App\Models\Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            // Get unread notifications count
            $unreadNotifications = \App\Models\Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
            
            // Return with basic data
            return view('adviser-dashboard', [
                'user' => $user,
                'adviser' => null,
                'students' => collect(),
                'totalStudents' => 0,
                'studentsWithAllergies' => 0,
                'recentVisits' => collect(),
                'pendingVisits' => 0,
                'notifications' => $notifications,
                'unreadNotifications' => $unreadNotifications
            ]);
        } catch (\Exception $e) {
            Log::error('Adviser Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    public function clinicStaffDashboard()
    {
        try {
            // Check authentication first
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }

            $user = Auth::user();
            
            // Ensure this is actually clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied. Clinic staff role required.');
            }
            
            return view('clinic-staff-dashboard', ['user' => $user]);
        } catch (\Exception $e) {
            Log::error('Clinic Staff Dashboard Error: ' . $e->getMessage());
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
            
            Log::info('Dashboard Index - User Role Check', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name
            ]);
            
            // Redirect to appropriate dashboard based on role
            switch ($user->role) {
                case 'student':
                    Log::info('Redirecting to student dashboard');
                    return redirect()->route('student.dashboard');
                case 'adviser':
                    Log::info('Redirecting to adviser dashboard');
                    return redirect()->route('adviser.dashboard');
                case 'clinic_staff':
                    Log::info('Redirecting to clinic staff dashboard');
                    return redirect()->route('clinic-staff.dashboard');
                case 'admin':
                    Log::info('Loading admin dashboard');
                    // For admin, show generic dashboard
                    break;
                default:
                    Log::warning('Unknown role detected', ['role' => $user->role]);
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
            Log::error('Dashboard Index Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'An error occurred. Please try logging in again.');
        }
    }

    private function studentDashboardView($user)
    {
        try {
            Log::info('Loading student dashboard view for user: ' . $user->name);
            
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
                    Log::info('Student record found: ' . $student->first_name . ' ' . $student->last_name);
                    
                    // Calculate age if birth date exists
                    if ($student->date_of_birth) {
                        try {
                            $age = \Carbon\Carbon::parse($student->date_of_birth)->age;
                        } catch (\Exception $e) {
                            Log::info('Age calculation failed: ' . $e->getMessage());
                            $age = '';
                        }
                    }
                } else {
                    Log::info('No student record found, using default values');
                }
            } catch (\Exception $e) {
                Log::error('Error finding student record: ' . $e->getMessage());
            }

            Log::info('Student Dashboard Data Prepared Successfully', [
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
            Log::error('Student Dashboard View Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
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
                Log::info('No adviser record found, using basic data', ['user_id' => $user->id]);
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
                Log::info('ClinicVisit model not available: ' . $e->getMessage());
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
                Log::info('Pending visits count not available: ' . $e->getMessage());
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
            Log::error('Adviser Dashboard View Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
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
            Log::info('Loading clinic staff dashboard view');
            
            // For now, just return the clinic staff dashboard with basic data
            // In the future, this can be populated with actual health status data
            
            return view('clinic-staff-dashboard', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Clinic Staff Dashboard View Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
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
        }

        return view('student-profile', compact('user', 'student'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:80',
                'middle_name' => 'nullable|string|max:80',
                'last_name' => 'required|string|max:80',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:20',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|in:M,F',
                'grade_level' => 'nullable|string|max:20',
                'section' => 'nullable|string|max:50',
                'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'address' => 'nullable|string',
                'emergency_contact' => 'nullable|string|max:150',
            ]);

            // Update user email and name
            $user->email = $validated['email'];
            $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->save();
            }

            // Get or create student record
            $nameParts = explode(' ', $user->name);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            $student = Student::where('first_name', $firstName)
                             ->where('last_name', $lastName)
                             ->first();

            if (!$student) {
                // Create new student record
                $student = new Student();
            }

            // Update student record with correct field names
            $student->first_name = $validated['first_name'];
            $student->middle_name = $validated['middle_name'];
            $student->last_name = $validated['last_name'];
            $student->date_of_birth = $validated['birth_date'];
            $student->gender = $validated['gender'];
            $student->grade_level = $validated['grade_level'];
            $student->section = $validated['section'];
            $student->blood_type = $validated['blood_type'];
            $student->address = $validated['address'];
            $student->emergency_contact = $validated['emergency_contact'];
            $student->contact_number = $validated['phone_number']; // Use contact_number instead of phone_number
            if ($student instanceof \Illuminate\Database\Eloquent\Model) {
                $student->save();
            }

            return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your profile. Please try again.')->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validate the request
            $validated = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            // Check if current password is correct
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }

            // Update password
            $user->password = Hash::make($validated['password']);
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->save();
            }

            return redirect()->route('student.profile')->with('success', 'Password updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Password Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your password.');
        }
    }

    public function uploadProfilePicture(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'student') {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
            
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);
            
            // Create uploads directory in public folder
            $uploadPath = public_path('uploads/profile_pictures');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }
            
            // Store new profile picture
            $file = $request->file('profile_picture');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to public/uploads/profile_pictures
            $file->move($uploadPath, $filename);
            
            // Update user record with relative path
            $relativePath = 'uploads/profile_pictures/' . $filename;
            $user->profile_picture = $relativePath;
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'profile_picture_url' => asset($relativePath)
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file. Please upload a valid image (JPEG, PNG, JPG, GIF) under 5MB.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Profile picture upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the profile picture. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show clinic staff students page
     */
    public function clinicStaffStudents(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Get all students - simplified query without relationships for now
            $students = Student::orderBy('last_name')
                ->orderBy('first_name')
                ->get();

            // Add computed properties for each student
            $students->each(function ($student) {
                // Format student number
                $student->formatted_student_number = $student->student_id ?? 'N/A';
                
                // Format grade and section
                $student->formatted_grade_section = $student->grade_level && $student->section 
                    ? "Grade {$student->grade_level} - {$student->section}" 
                    : 'N/A';
                
                // Get last visit date - simplified for now
                $student->last_visit_date = 'No visits';
                
                // Check if student has allergies from JSON field
                $studentAllergies = $student->getAttribute('allergies');
                $student->has_allergies = !empty($studentAllergies) && is_array($studentAllergies) && count($studentAllergies) > 0;
                $student->allergy_status = $student->has_allergies ? 'Yes' : 'None';
            });

            return view('clinic-staff-students', compact('user', 'students'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Students Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.dashboard')->with('error', 'An error occurred loading students.');
        }
    }

    /**
     * Show individual student profile for clinic staff
     */
    public function clinicStaffStudentProfile($id)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            $student = Student::with(['visits', 'allergies', 'vitals', 'immunizations'])
                ->findOrFail($id);

            return view('clinic-staff-student-profile', compact('user', 'student'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Student Profile Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.students')->with('error', 'Student not found.');
        }
    }

    /**
     * Add a new visit for a student
     */
    public function addStudentVisit(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            $student = Student::findOrFail($id);

            // Create new visit (you can expand this based on your visit model)
            $visit = new ClinicVisit([
                'student_id' => $student->id,
                'visit_date' => now(),
                'visit_type' => $request->input('visit_type', 'General Checkup'),
                'notes' => $request->input('notes'),
                'staff_id' => $user->id
            ]);
            
            $visit->save();

            return redirect()->route('clinic-staff.student.profile', $id)
                ->with('success', 'Visit added successfully.');

        } catch (\Exception $e) {
            Log::error('Add Student Visit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add visit.');
        }
    }

    /**
     * Show clinic staff visits page
     */
    public function clinicStaffVisits(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Get all medical visits with student information
            $visits = MedicalVisit::with(['student'])
                ->orderBy('visit_datetime', 'desc')
                ->get();

            // Add computed properties for each visit
            $visits->each(function ($visit) {
                // Format datetime
                $visit->formatted_datetime = $visit->visit_datetime->format('M d, Y h:i A');
                
                // Get primary diagnosis - simplified for now since tables might not exist
                $visit->primary_diagnosis = 'Pending';
            });

            return view('clinic-staff-visits', compact('user', 'visits'));

        } catch (\Exception $e) {
            Log::error('Clinic Staff Visits Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.dashboard')->with('error', 'An error occurred loading visits.');
        }
    }

    /**
     * Get visit details for AJAX request
     */
    public function getVisitDetails($visitId)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return response()->json(['error' => 'Access denied'], 403);
            }

            $visit = MedicalVisit::with(['student'])->findOrFail($visitId);

            // Format the data for the modal - simplified version
            $visitData = [
                'visit_id' => $visit->visit_id,
                'visit_type' => $visit->visit_type,
                'status' => $visit->status,
                'chief_complaint' => $visit->chief_complaint,
                'notes' => $visit->notes,
                'formatted_datetime' => $visit->visit_datetime->format('M d, Y h:i A'),
                'student' => [
                    'full_name' => $visit->student->first_name . ' ' . $visit->student->last_name,
                    'student_number' => $visit->student->student_id ?? 'N/A',
                    'grade_section' => $visit->student->grade_level && $visit->student->section 
                        ? "Grade {$visit->student->grade_level} - {$visit->student->section}" 
                        : 'N/A',
                    'age' => $visit->student->date_of_birth 
                        ? \Carbon\Carbon::parse($visit->student->date_of_birth)->age 
                        : 'N/A'
                ],
                'clinic_staff' => null, // Simplified for now
                'diagnoses' => [], // Will be populated when tables exist
                'medications' => [], // Will be populated when tables exist
                'treatments' => [], // Will be populated when tables exist
                'vitals' => [] // Will be populated when tables exist
            ];

            return response()->json($visitData);

        } catch (\Exception $e) {
            Log::error('Get Visit Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Visit not found'], 404);
        }
    }

    /**
     * Store a new medical visit
     */
    public function storeVisit(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            // Validate the request
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'visit_datetime' => 'required|date',
                'visit_type' => 'required|in:Routine,Emergency,Follow-up,Referral',
                'chief_complaint' => 'required|string|max:255',
                'notes' => 'nullable|string',
            ]);

            // Create the medical visit
            $visit = MedicalVisit::create([
                'student_id' => $validated['student_id'],
                'clinic_staff_id' => null, // We'll set this properly later when we have clinic staff records
                'visit_datetime' => $validated['visit_datetime'],
                'visit_type' => $validated['visit_type'],
                'chief_complaint' => $validated['chief_complaint'],
                'notes' => $validated['notes'],
                'status' => 'Open'
            ]);

            return redirect()->route('clinic-staff.visits')->with('success', 'Visit created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Store Visit Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the visit: ' . $e->getMessage());
        }
    }

    /**
     * Search students for visit creation
     */
    public function searchStudents(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return response()->json(['error' => 'Access denied'], 403);
            }

            $query = $request->get('q', '');
            
            if (strlen($query) < 2) {
                return response()->json(['students' => []]);
            }

            // Search students by name or student ID
            $students = Student::where(function($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                  ->orWhere('last_name', 'LIKE', "%{$query}%")
                  ->orWhere('student_id', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'first_name', 'last_name', 'student_id', 'grade_level', 'section']);

            return response()->json(['students' => $students]);

        } catch (\Exception $e) {
            Log::error('Search Students Error: ' . $e->getMessage());
            return response()->json(['students' => []], 500);
        }
    }

    /**
     * Show clinic staff profile page
     */
    public function clinicStaffProfile()
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            return view('clinic-staff-profile', compact('user'));

        } catch (\Exception $e) {
            \Log::error('Clinic Staff Profile Error: ' . $e->getMessage());
            return redirect()->route('clinic-staff.dashboard')->with('error', 'An error occurred loading profile.');
        }
    }

    /**
     * Update clinic staff profile
     */
    public function updateClinicStaffProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Debug logging
            \Log::info('Profile update attempt', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'request_data' => $request->all(),
                'request_method' => $request->method(),
                'request_url' => $request->url()
            ]);
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                \Log::error('Access denied - not clinic staff', ['role' => $user->role]);
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:20',
                'staff_code' => 'nullable|string|max:50',
                'position' => 'nullable|string|max:100',
            ]);

            \Log::info('Validation passed', ['validated_data' => $validated]);

            // Store old values for comparison
            $oldValues = [
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'staff_code' => $user->staff_code,
                'position' => $user->position,
            ];

            // Update user record
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone_number = $validated['phone_number'] ?? null;
            $user->staff_code = $validated['staff_code'] ?? null;
            $user->position = $validated['position'] ?? null;
            
            // Check if there are any changes
            $changes = $user->getDirty();
            
            if (empty($changes)) {
                \Log::info('No changes detected in profile update');
                return redirect()->route('clinic-staff.profile')->with('info', 'No changes were made to your profile.');
            }
            
            $saved = $user->save();

            \Log::info('Profile update result', [
                'saved' => $saved,
                'old_values' => $oldValues,
                'new_values' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'staff_code' => $user->staff_code,
                    'position' => $user->position,
                ],
                'user_dirty' => $user->getDirty(),
                'user_changes' => $user->getChanges(),
                'changes_made' => $changes
            ]);

            if ($saved) {
                return redirect()->route('clinic-staff.profile')->with('success', 'Profile updated successfully!');
            } else {
                \Log::error('Failed to save user profile');
                return redirect()->back()->with('error', 'Failed to update profile. Please try again.')->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in profile update', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Clinic Staff Profile Update Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while updating your profile. Please try again: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update clinic staff password
     */
    public function updateClinicStaffPassword(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is clinic staff
            if ($user->role !== 'clinic_staff') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Validate the request
            $validated = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            // Check if current password is correct
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }

            // Update password
            $user->password = Hash::make($validated['password']);
            $user->save();

            return redirect()->route('clinic-staff.profile')->with('success', 'Password updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Clinic Staff Password Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your password.');
        }
    }

    /**
     * Upload clinic staff profile picture
     */
    public function uploadClinicStaffProfilePicture(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'clinic_staff') {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
            
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);
            
            // Create uploads directory in public folder
            $uploadPath = public_path('uploads/profile_pictures');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }
            
            // Store new profile picture
            $file = $request->file('profile_picture');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to public/uploads/profile_pictures
            $file->move($uploadPath, $filename);
            
            // Update user record with relative path
            $relativePath = 'uploads/profile_pictures/' . $filename;
            $user->profile_picture = $relativePath;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'profile_picture_url' => asset($relativePath)
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file. Please upload a valid image (JPEG, PNG, JPG, GIF) under 5MB.'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Profile picture upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the profile picture. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show adviser profile page
     */
    public function adviserProfile()
    {
        try {
            $user = Auth::user();
            
            // Ensure this is an adviser
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Get adviser record if it exists
            $adviser = Adviser::where('user_id', $user->id)->first();

            return view('adviser-profile', compact('user', 'adviser'));

        } catch (\Exception $e) {
            \Log::error('Adviser Profile Error: ' . $e->getMessage());
            return redirect()->route('adviser.dashboard')->with('error', 'An error occurred loading profile.');
        }
    }

    /**
     * Update adviser profile
     */
    public function updateAdviserProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Debug logging
            \Log::info('Adviser profile update attempt', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'request_data' => $request->all(),
                'request_method' => $request->method(),
                'request_url' => $request->url()
            ]);
            
            // Ensure this is an adviser
            if ($user->role !== 'adviser') {
                \Log::error('Access denied - not adviser', ['role' => $user->role]);
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'contact_number' => 'nullable|string|max:20',
                'birthday' => 'nullable|date',
                'gender' => 'nullable|in:male,female',
                'address' => 'nullable|string',
                'employee_number' => 'nullable|string|max:50',
                'position' => 'nullable|string|max:100',
                'department' => 'nullable|string|max:100',
            ]);

            \Log::info('Validation passed', ['validated_data' => $validated]);

            // Store old values for comparison
            $oldValues = [
                'name' => $user->name,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'contact_number' => $user->contact_number,
                'birthday' => $user->birthday,
                'gender' => $user->gender,
                'address' => $user->address,
                'employee_number' => $user->employee_number,
                'position' => $user->position,
                'department' => $user->department,
            ];

            // Update user record with registration fields
            $fullName = $validated['first_name'] . ' ' . 
                       ($validated['middle_name'] ? $validated['middle_name'] . ' ' : '') . 
                       $validated['last_name'];
            
            $user->name = $fullName;
            $user->email = $validated['email'];
            $user->first_name = $validated['first_name'];
            $user->middle_name = $validated['middle_name'];
            $user->last_name = $validated['last_name'];
            $user->contact_number = $validated['contact_number'];
            $user->birthday = $validated['birthday'];
            $user->gender = $validated['gender'];
            $user->address = $validated['address'];
            $user->employee_number = $validated['employee_number'];
            $user->position = $validated['position'];
            $user->department = $validated['department'];
            
            // Check if there are any changes
            $changes = $user->getDirty();
            
            if (empty($changes)) {
                \Log::info('No changes detected in adviser profile update');
                return redirect()->route('adviser.profile')->with('info', 'No changes were made to your profile.');
            }
            
            $saved = $user->save();

            \Log::info('Adviser profile update result', [
                'saved' => $saved,
                'old_values' => $oldValues,
                'new_values' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'contact_number' => $user->contact_number,
                    'birthday' => $user->birthday,
                    'gender' => $user->gender,
                    'address' => $user->address,
                    'employee_number' => $user->employee_number,
                    'position' => $user->position,
                    'department' => $user->department,
                ],
                'user_dirty' => $user->getDirty(),
                'user_changes' => $user->getChanges(),
                'changes_made' => $changes
            ]);

            if ($saved) {
                return redirect()->route('adviser.profile')->with('success', 'Profile updated successfully!');
            } else {
                \Log::error('Failed to save adviser profile');
                return redirect()->back()->with('error', 'Failed to update profile. Please try again.')->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in adviser profile update', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Adviser Profile Update Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while updating your profile. Please try again: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update adviser password
     */
    public function updateAdviserPassword(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Ensure this is an adviser
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Validate the request
            $validated = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            // Check if current password is correct
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }

            // Update password
            $user->password = Hash::make($validated['password']);
            $user->save();

            return redirect()->route('adviser.profile')->with('success', 'Password updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Adviser Password Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your password.');
        }
    }

    /**
     * Upload adviser profile picture
     */
    public function uploadAdviserProfilePicture(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'adviser') {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
            }
            
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);
            
            // Create uploads directory in public folder
            $uploadPath = public_path('uploads/profile_pictures');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }
            
            // Store new profile picture
            $file = $request->file('profile_picture');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to public/uploads/profile_pictures
            $file->move($uploadPath, $filename);
            
            // Update user record with relative path
            $relativePath = 'uploads/profile_pictures/' . $filename;
            $user->profile_picture = $relativePath;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'profile_picture_url' => asset($relativePath)
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file. Please upload a valid image (JPEG, PNG, JPG, GIF) under 5MB.'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Adviser profile picture upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the profile picture. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}