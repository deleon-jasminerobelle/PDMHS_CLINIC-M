<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalVisitSeeder extends Seeder
{
    public function run()
    {
        $visitTypes = ['Routine', 'Emergency', 'Follow-up', 'Referral'];
        $complaints = [
            'Headache',
            'Stomach ache',
            'Fever',
            'Cough and cold',
            'Minor injury',
            'Routine check-up',
            'Vaccination',
            'Physical examination'
        ];
        $statuses = ['Open', 'Closed', 'Referred'];

        // Get student IDs from the students table
        $studentIds = DB::table('students')->pluck('student_id');

        foreach ($studentIds as $studentId) {
            // Create 2-5 medical visits per student
            $visitCount = rand(2, 5);
            
            for ($i = 0; $i < $visitCount; $i++) {
                $visitDate = Carbon::now()->subDays(rand(1, 365));
                
                DB::table('medical_visits')->insert([
                    'student_id' => $studentId,
                    'clinic_staff_id' => null, // Will be populated when clinic staff is created
                    'visit_datetime' => $visitDate,
                    'visit_type' => $visitTypes[array_rand($visitTypes)],
                    'chief_complaint' => $complaints[array_rand($complaints)],
                    'notes' => 'Student visited clinic for ' . strtolower($complaints[array_rand($complaints)]),
                    'status' => $statuses[array_rand($statuses)],
                    'created_at' => $visitDate
                ]);
            }
        }
    }
}