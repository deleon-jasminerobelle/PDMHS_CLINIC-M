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


    public function index()
    {
        $user = Auth::user();
        
        // Check if user is a student
        if ($user->role === 'student') {
            return $this->studentDashboard($user);
        }
        
        // Check if user is an adviser
        if ($user->role === 'adviser') {
            return $this->adviserDashboard($user);
        }
        
        // Get dashboard statistics for staff/admin
        $stats = [
            'total_students' => Student::count(),
            'total_visits_today' => ClinicVisit::whereDate('created_at', today())->count(),
            'pending_visits' => ClinicVisit::where('status', 'pending')->count(),
            'total_immunizations' => Immunization::count(),
        ];

        // Get recent activities
        $recent_visits = ClinicVisit::with(['student'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('user', 'stats', 'recent_visits'));
    }

    private function studentDashboard($user)
    {
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

        try {
            // Get student's clinic visits with vitals
            $clinicVisits = $student->clinicVisits()
                ->with(['vitals'])
                ->orderBy('visit_date', 'desc')
                ->get();

            $lastVisit = $clinicVisits->first();

            // Get latest vitals from the most recent visit
            $latestVitals = null;
            $bmi = null;
            $bmiCategory = null;
            
            if ($lastVisit && $lastVisit->vitals->isNotEmpty()) {
                $latestVitals = $lastVisit->vitals->first();
                $bmi = $latestVitals->bmi;
                $bmiCategory = $latestVitals->bmi_category;
            }

            // Get allergies
            $allergies = $student->allergies ?? collect();

            // Get immunization records
            $immunizations = $student->immunizations()
                ->orderBy('date_administered', 'desc')
                ->get();

            // Calculate age
            $age = $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->age : null;

            // Get recent clinic visits (last 5)
            $recentVisits = $clinicVisits->take(5);

            // Count total visits
            $totalVisits = $clinicVisits->count();
        } catch (\Exception $e) {
            \Log::error('Student Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }

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
            'totalVisits'
        ));
    }

    private function adviserDashboard($user)
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
}