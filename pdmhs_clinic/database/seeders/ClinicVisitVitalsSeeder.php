<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClinicVisit;
use App\Models\Vitals;
use Carbon\Carbon;

class ClinicVisitVitalsSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        
        $reasons = [
            'Headache',
            'Stomach ache', 
            'Fever',
            'Cough and cold',
            'Minor injury',
            'Routine check-up',
            'Physical examination',
            'Vaccination'
        ];

        $statuses = ['pending', 'in_progress', 'completed'];

        foreach ($students as $student) {
            // Create 2-4 clinic visits per student
            $visitCount = rand(2, 4);
            
            for ($i = 0; $i < $visitCount; $i++) {
                $visitDate = Carbon::now()->subDays(rand(1, 180));
                
                $clinicVisit = ClinicVisit::create([
                    'student_id' => $student->id,
                    'visit_date' => $visitDate,
                    'reason_for_visit' => $reasons[array_rand($reasons)],
                    'symptoms' => 'Patient reported symptoms during visit',
                    'status' => $statuses[array_rand($statuses)],
                    'diagnosis' => 'Preliminary diagnosis based on symptoms',
                    'treatment' => 'Recommended treatment plan',
                    'medications' => 'Prescribed medications if any',
                    'follow_up_required' => rand(0, 1),
                    'notes' => 'Additional notes from the visit'
                ]);

                // Create vitals for completed visits
                if ($clinicVisit->status === 'completed') {
                    // Generate realistic vitals for teenagers
                    $age = Carbon::parse($student->date_of_birth)->age;
                    $baseWeight = max(40, $age * 3 + rand(-10, 15)); // Realistic weight
                    $baseHeight = rand(150, 180); // Height in cm
                    
                    Vitals::create([
                        'clinic_visit_id' => $clinicVisit->id,
                        'temperature' => 36.5 + (rand(-5, 15) / 10), // 36.0 - 38.0°C
                        'blood_pressure' => rand(110, 130) . '/' . rand(70, 85),
                        'heart_rate' => rand(60, 100),
                        'respiratory_rate' => rand(12, 20),
                        'weight' => $baseWeight,
                        'height' => $baseHeight,
                        'notes' => 'Vital signs recorded during visit'
                    ]);
                }
            }
        }
    }
}