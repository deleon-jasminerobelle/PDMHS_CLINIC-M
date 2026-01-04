<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\StudentHealthService;
use App\Models\User;

class StudentDashboardController extends Controller
{
    use StudentHealthService;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show student dashboard
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $student = $this->getStudentForUser($user);

        // Get health-related data
        $latestVitals = $this->getLatestVitalsForStudent($student);
        $bmiData = $this->calculateBMI($latestVitals, $student);
        $bmi = $bmiData['bmi'];
        $bmiCategory = $bmiData['category'];
        $allergies = $this->getAllergiesForStudent($student);
        $clinicVisits = $this->getClinicVisitsForStudent($student);
        $bloodType = $student->blood_type ?? '';
        $age = $student->age ?? '';
        $lastVisit = $clinicVisits->first();

        return view('student-dashboard', compact(
            'user',
            'student',
            'latestVitals',
            'bmi',
            'bmiCategory',
            'allergies',
            'clinicVisits',
            'bloodType',
            'age',
            'lastVisit'
        ));
    }



    /**
     * Update student profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'name' => $validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'] ?? null,
            'birthday' => $validated['birthday'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update student password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('student.profile')->with('success', 'Password updated successfully!');
    }

    /**
     * Upload profile picture
     */
    public function uploadProfilePicture(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:' . config('clinic.max_profile_picture_size', 2048),
        ]);

        $uploadPath = public_path('uploads/profile_pictures');
        if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true);

        if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
            unlink(public_path($user->profile_picture));
        }

        $file = $request->file('profile_picture');
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        $user->update(['profile_picture' => 'uploads/profile_pictures/' . $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated',
            'profile_picture_url' => asset('uploads/profile_pictures/' . $filename),
        ]);
    }

    /**
     * Show student medical overview
     */
    public function medical()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $student = $this->getStudentForUser($user);
        $clinicVisits = $this->getClinicVisitsForStudent($student);

        $totalVisits = $clinicVisits->count();
        $recentVisits = $clinicVisits->filter(fn($visit) => $visit->created_at >= now()->subDays(30))->count();
        $allergies = $this->getAllergiesForStudent($student);

        return view('student-medical', compact('user', 'totalVisits', 'recentVisits', 'allergies'));
    }

    /**
     * Show student profile edit form
     */
    public function profile()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $student = $this->getStudentForUser($user);

        return view('student-profile', compact('user', 'student'));
    }

    /**
     * Get allergies for the current student
     */
    public function getAllergies()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            return response()->json(['error' => 'Access denied.'], 403);
        }

        $student = $this->getStudentForUser($user);
        $allergies = $this->getAllergiesForStudent($student);

        return response()->json(['allergies' => $allergies]);
    }

    /**
     * Update allergies for the current student
     */
    public function updateAllergies(Request $request)
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            return response()->json(['error' => 'Access denied.'], 403);
        }

        $request->validate([
            'allergies' => 'required|array',
            'allergies.*.allergy_name' => 'required|string|max:255',
            'allergies.*.severity' => 'required|in:mild,moderate,severe',
        ]);

        $student = $this->getStudentForUser($user);

        // Update allergies in the student record
        $student->update([
            'allergies' => $request->allergies,
            'has_allergies' => count($request->allergies) > 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Allergies updated successfully!'
        ]);
    }

    // You can add other methods (info, medicalHistory) here as needed
}
