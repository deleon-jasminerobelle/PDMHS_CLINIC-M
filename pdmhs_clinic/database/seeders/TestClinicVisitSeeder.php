<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClinicVisit;

class TestClinicVisitSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        
        if ($students->count() > 0) {
            // Create some test clinic visits
            $visits = [
                [
                    'student_id' => $students->first()->id,
                    'visit_date' => now()->subDays(2),
                    'reason_for_visit' => 'Headache',
                    'symptoms' => 'Mild headache, no fever',
                    'status' => 'completed',
                    'diagnosis' => 'Tension headache',
                    'treatment' => 'Rest and hydration',
                    'notes' => 'Student complained of mild headache. Advised to rest.'
                ],
                [
                    'student_id' => $students->skip(1)->first()->id,
                    'visit_date' => now()->subDays(1),
                    'reason_for_visit' => 'Stomach pain',
                    'symptoms' => 'Acute abdominal pain',
                    'status' => 'pending',
                    'diagnosis' => 'Under observation',
                    'treatment' => 'Monitoring',
                    'notes' => 'Acute stomach pain. Parent contacted.'
                ],
                [
                    'student_id' => $students->skip(2)->first()->id,
                    'visit_date' => now()->subHours(3),
                    'reason_for_visit' => 'Fever follow-up',
                    'symptoms' => 'No fever, feeling better',
                    'status' => 'completed',
                    'diagnosis' => 'Recovered',
                    'treatment' => 'None required',
                    'notes' => 'Temperature normal. Feeling better.'
                ]
            ];

            foreach ($visits as $visitData) {
                ClinicVisit::create($visitData);
            }
        }
    }
}