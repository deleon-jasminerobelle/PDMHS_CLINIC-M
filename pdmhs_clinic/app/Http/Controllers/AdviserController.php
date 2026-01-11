<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Adviser;
use App\Models\User;
use App\Models\ClinicVisit;
use App\Models\Student;
use App\Traits\StudentHealthService;

class AdviserController extends Controller
{
    use StudentHealthService;

    /**
     * Adviser Dashboard
     */
    public function adviserDashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Load adviser with related students
            $adviser = Adviser::where('user_id', $user->id)->with('students')->first();
            $students = $adviser->students ?? collect();

            // Fetch dashboard statistics
            $totalStudents = $students->count();
            $recentVisits = ClinicVisit::whereHas('student', function($query) use ($students) {
                $query->whereIn('id', $students->pluck('id'));
            })->with('student')->orderBy('visit_date', 'desc')->limit(10)->get();

            $studentsWithAllergies = $students->where('allergies', '!=', '')->whereNotNull('allergies');

            // Prepare recent activities for display
            $recentActivities = $recentVisits->take(5)->map(function ($visit) {
                return (object) [
                    'student_name' => $visit->student->first_name . ' ' . $visit->student->last_name,
                    'type' => 'Clinic Visit',
                    'date' => $visit->visit_date->format('M d, Y')
                ];
            });

            $studentsData = $students->map(function ($student) {
                $latestVitals = $this->getLatestVitalsForStudent($student);
                $bmiData = $this->calculateBMI($latestVitals, $student);
                $bmi = $bmiData['bmi'];
                $bmiCategory = $bmiData['category'];
                $allergies = $this->getAllergiesForStudent($student);
                $clinicVisits = $this->getClinicVisitsForStudent($student);

                return [
                    'student' => $student,
                    'latestVitals' => $latestVitals,
                    'bmi' => $bmi,
                    'bmiCategory' => $bmiCategory,
                    'allergies' => $allergies,
                    'clinicVisits' => $clinicVisits,
                ];
            });

            // Fetch all students for adviser access
            $allStudents = Student::with('user')->paginate(20);

            return view('adviser-dashboard', compact('studentsData', 'students', 'totalStudents', 'recentVisits', 'studentsWithAllergies', 'adviser', 'allStudents', 'user'));

        } catch (\Exception $e) {
            Log::error('Adviser Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to load dashboard.');
        }
    }

    /**
     * Adviser My Students
     */
    public function myStudents()
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            // Load adviser with related students
            $adviser = Adviser::where('user_id', $user->id)->with(['students.user'])->first();
            $students = $adviser->students ?? collect();

            $studentsData = $students->map(function ($student) {
                $latestVitals = $this->getLatestVitalsForStudent($student);
                $bmiData = $this->calculateBMI($latestVitals, $student);
                $bmi = $bmiData['bmi'];
                $bmiCategory = $bmiData['category'];
                $allergies = $this->getAllergiesForStudent($student);
                $clinicVisits = $this->getClinicVisitsForStudent($student);

                return [
                    'student' => $student,
                    'latestVitals' => $latestVitals,
                    'bmi' => $bmi,
                    'bmiCategory' => $bmiCategory,
                    'allergies' => $allergies,
                    'clinicVisits' => $clinicVisits,
                ];
            });

            return view('adviser-my-students', compact('studentsData', 'students', 'adviser', 'user'));

        } catch (\Exception $e) {
            Log::error('Adviser My Students Error: ' . $e->getMessage());
            return redirect()->route('adviser.dashboard')->with('error', 'Unable to load students.');
        }
    }

    /**
     * Adviser Profile
     */
    public function adviserProfile()
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error','Access denied.');
            }

            $adviser = Adviser::where('user_id', $user->id)->first();
            return view('adviser-profile', compact('user','adviser'));

        } catch (\Exception $e) {
            Log::error('Adviser Profile Error: ' . $e->getMessage());
            return redirect()->route('adviser.dashboard')->with('error','Error loading profile.');
        }
    }

    /**
     * Update Adviser Profile
     */
    public function updateAdviserProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error','Access denied.');
            }

            $validated = $request->validate([
                'first_name'=>'required|string|max:255',
                'last_name'=>'required|string|max:255',
                'middle_name'=>'nullable|string|max:255',
                'email'=>'required|email|max:255|unique:users,email,'.$user->id,
                'contact_number'=>'nullable|string|max:20',
                'birthday'=>'nullable|date',
                'gender'=>'nullable|in:male,female',
                'address'=>'nullable|string',
                'employee_number'=>'nullable|string|max:50',
                'position'=>'nullable|string|max:100',
                'department'=>'nullable|string|max:100',
            ]);

            $user->update([
                'name' => $validated['first_name'].' '.($validated['middle_name']??'').' '.$validated['last_name'],
                'first_name'=>$validated['first_name'],
                'middle_name'=>$validated['middle_name'],
                'last_name'=>$validated['last_name'],
                'email'=>$validated['email'],
                'contact_number'=>$validated['contact_number'],
                'birthday'=>$validated['birthday'],
                'gender'=>$validated['gender'],
                'address'=>$validated['address'],
                'employee_number'=>$validated['employee_number'],
                'position'=>$validated['position'],
                'department'=>$validated['department'],
            ]);

            return redirect()->route('adviser.profile')->with('success','Profile updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Adviser Profile Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error','Error updating profile.')->withInput();
        }
    }

    /**
     * Update Adviser Password
     */
    public function updateAdviserPassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error','Access denied.');
            }

            $validated = $request->validate([
                'current_password'=>'required',
                'password'=>'required|min:8|confirmed'
            ]);

            if (!Hash::check($validated['current_password'],$user->password)) {
                return redirect()->back()->with('error','Current password is incorrect.');
            }

            $user->update(['password'=>Hash::make($validated['password'])]);

            return redirect()->route('adviser.profile')->with('success','Password updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Adviser Password Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error','Error updating password.');
        }
    }

    /**
     * Upload Adviser Profile Picture
     */
    public function uploadAdviserProfilePicture(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if (!$user || $user->role !== 'adviser') {
                return response()->json(['success'=>false,'message'=>'Unauthorized'],403);
            }

            $request->validate([
                'profile_picture'=>'required|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            $uploadPath = public_path('uploads/profile_pictures');
            if (!file_exists($uploadPath)) mkdir($uploadPath,0755,true);

            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = 'profile_'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

            $user->update(['profile_picture'=>'uploads/profile_pictures/'.$filename]);

            return response()->json([
                'success'=>true,
                'message'=>'Profile picture updated',
                'profile_picture_url'=>asset('uploads/profile_pictures/'.$filename)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success'=>false,'message'=>'Invalid image file.'],422);
        } catch (\Exception $e) {
            Log::error('Adviser Profile Picture Upload Error: ' . $e->getMessage());
            return response()->json(['success'=>false,'message'=>'Error uploading profile picture.'],500);
        }
    }

    /**
     * View Student Profile
     */
    public function viewStudentProfile($id)
    {
        /** @var User $user */
        $user = Auth::user();

        try {
            if ($user->role !== 'adviser') {
                return redirect()->route('login')->with('error', 'Access denied.');
            }

            $student = Student::with('user')->findOrFail($id);

            // Get student health data using the trait
            $latestVitals = $this->getLatestVitalsForStudent($student);
            $bmiData = $this->calculateBMI($latestVitals, $student);
            $allergies = $this->getAllergiesForStudent($student);
            $clinicVisits = $this->getClinicVisitsForStudent($student);

            return view('adviser-student-profile', compact(
                'user',
                'student',
                'latestVitals',
                'bmiData',
                'allergies',
                'clinicVisits'
            ));

        } catch (\Exception $e) {
            Log::error('Adviser View Student Profile Error: ' . $e->getMessage());
            return redirect()->route('adviser.dashboard')->with('error', 'Unable to load student profile.');
        }
    }
}

