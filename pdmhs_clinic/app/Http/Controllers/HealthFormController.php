<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class HealthFormController extends Controller
{
    public function index()
    {
        return view('student-health-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lrn' => 'required|string|max:50',
            'school' => 'required|string|max:255',
            'grade_section' => 'required|string|max:50',
            'birthday' => 'required|date',
            'sex' => 'required|in:M,F',
            'age' => 'required|integer|min:1',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_relation' => 'required|string|max:50',
            'emergency_address' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'parent_signature' => 'required|string|max:255',
            'signature_date' => 'required|date',
            'parent_relationship' => 'required|string|max:50',
            'parent_contact' => 'required|string|max:20',
        ]);

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
            'Others',
        ];

        $vaccinationHistory = [];
        foreach ($vaccines as $vaccine) {
            $slug = Str::slug($vaccine);
            if ($request->input("vaccine_{$slug}")) {
                $vaccinationHistory[$slug] = [
                    'given' => true,
                    'date' => $request->input("vaccine_date_{$slug}"),
                ];
            }
        }

        $height = (float) $request->input('height', 0);
        $weight = (float) $request->input('weight', 0);
        $bmi = ($height > 0 && $weight > 0)
            ? round($weight / pow($height / 100, 2), 2)
            : 'N/A';

        [$first, $last] = array_pad(explode(' ', $request->input('name'), 2), 2, '');

        [$grade, $section] = array_pad(
            explode(' ', $request->input('grade_section'), 2),
            2,
            ''
        );

        Student::updateOrCreate(
            ['student_id' => $request->input('lrn')],
            [
                'first_name' => $first,
                'last_name' => $last,
                'date_of_birth' => $request->input('birthday'),
                'grade_level' => $grade,
                'section' => $section,
                'school' => $request->input('school'),
                'sex' => $request->input('sex'),
                'age' => $request->input('age'),
                'emergency_contact_name' => $request->input('emergency_contact_name'),
                'emergency_contact_number' => $request->input('emergency_phone'),
                'emergency_relation' => $request->input('emergency_relation'),
                'emergency_address' => $request->input('emergency_address'),
                'parent_certification' => [
                    'signature' => $request->input('parent_signature'),
                    'date' => $request->input('signature_date'),
                    'relationship' => $request->input('parent_relationship'),
                    'contact' => $request->input('parent_contact'),
                ],
                'vaccination_history' => $vaccinationHistory,
                'bmi' => $bmi,
            ]
        );

        session(['student_id' => $request->input('lrn')]);

        return redirect()->route('student.dashboard');
    }
}
