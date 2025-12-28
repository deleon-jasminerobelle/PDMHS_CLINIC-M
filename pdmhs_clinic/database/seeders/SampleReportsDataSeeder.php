<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalVisit;
use App\Models\Student;
use Carbon\Carbon;

class SampleReportsDataSeeder extends Seeder
{
    public function run()
    {
        // Get some students
        $students = Student::take(10)->get();
        
        if ($students->count() == 0) {
            $this->command->info('No students found. Please run StudentSeeder first.');
            return;
        }

        $visitTypes = ['Routine', 'Emergency', 'Follow-up', 'Referral'];
        $complaints = [
            'Headache',
            'Fever',
            'Stomach ache',
            'Cough and cold',
            'Allergic reaction',
            'Minor injury',
            'Nausea',
            'Dizziness',
            'Sore throat',
            'Skin rash'
        ];
        $statuses = ['Open', 'Closed', 'Referred'];

        // Create sample medical visits for the last 60 days
        for ($i = 0; $i < 50; $i++) {
            $student = $students->random();
            $visitDate = Carbon::now()->subDays(rand(0, 60));
            
            MedicalVisit::create([
                'student_id' => $student->student_id,
                'clinic_staff_id' => 1, // Assuming clinic staff ID 1 exists
                'visit_datetime' => $visitDate,
                'visit_type' => $visitTypes[array_rand($visitTypes)],
                'chief_complaint' => $complaints[array_rand($complaints)],
                'notes' => 'Sample medical visit notes for testing reports.',
                'status' => $statuses[array_rand($statuses)],
            ]);
        }

        $this->command->info('Sample medical visits created for reports testing.');
    }
}