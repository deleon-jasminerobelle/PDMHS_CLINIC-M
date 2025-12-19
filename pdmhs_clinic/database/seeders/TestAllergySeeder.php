<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Allergy;

class TestAllergySeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        
        if ($students->count() > 0) {
            // Create some test allergies
            $allergies = [
                [
                    'student_id' => $students->first()->id,
                    'allergy_text' => 'Peanuts',
                    'severity' => 'Severe',
                    'recorded_at' => now()->format('Y-m-d')
                ],
                [
                    'student_id' => $students->skip(1)->first()->id,
                    'allergy_text' => 'Shellfish',
                    'severity' => 'Moderate',
                    'recorded_at' => now()->format('Y-m-d')
                ]
            ];

            foreach ($allergies as $allergyData) {
                // Check if allergies table exists and has the right structure
                try {
                    Allergy::create($allergyData);
                } catch (\Exception $e) {
                    // If allergies table doesn't exist or has different structure, skip
                    echo "Skipping allergies - table may not exist or have different structure\n";
                    break;
                }
            }
        }
    }
}