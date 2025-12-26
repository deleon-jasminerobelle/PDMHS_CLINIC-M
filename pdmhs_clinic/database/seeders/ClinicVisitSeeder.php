<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClinicVisit;
use App\Models\Student;

class ClinicVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        if ($students->count() > 0) {
            // Create some recent visits (within last 30 days)
            ClinicVisit::create([
                'student_id' => $students->first()->id,
                'visit_date' => now()->subDays(5)->format('Y-m-d'),
                'reason_for_visit' => 'Headache and fever',
                'symptoms' => 'Headache, fever, fatigue',
                'status' => 'completed',
                'diagnosis' => 'Common cold',
                'treatment' => 'Rest and hydration',
                'notes' => 'Student recovered well',
            ]);

            ClinicVisit::create([
                'student_id' => $students->skip(1)->first()->id,
                'visit_date' => now()->subDays(10)->format('Y-m-d'),
                'reason_for_visit' => 'Allergic reaction',
                'symptoms' => 'Rash, itching',
                'status' => 'completed',
                'diagnosis' => 'Allergic reaction to dust',
                'treatment' => 'Antihistamines prescribed',
                'notes' => 'Advised to avoid dust exposure',
            ]);

            // Create some pending visits
            ClinicVisit::create([
                'student_id' => $students->first()->id,
                'visit_date' => now()->addDays(2)->format('Y-m-d'),
                'reason_for_visit' => 'Follow-up check',
                'symptoms' => 'N/A',
                'status' => 'pending',
                'diagnosis' => null,
                'treatment' => null,
                'notes' => 'Scheduled follow-up for cold symptoms',
            ]);

            ClinicVisit::create([
                'student_id' => $students->skip(2)->first()->id,
                'visit_date' => now()->addDays(5)->format('Y-m-d'),
                'reason_for_visit' => 'Annual check-up',
                'symptoms' => 'N/A',
                'status' => 'pending',
                'diagnosis' => null,
                'treatment' => null,
                'notes' => 'Routine annual health check',
            ]);
        }
    }
}
