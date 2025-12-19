<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Allergy;

class AllergySeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        
        $allergies = [
            ['name' => 'Peanuts', 'severity' => 'Severe'],
            ['name' => 'Shellfish', 'severity' => 'Moderate'],
            ['name' => 'Dust', 'severity' => 'Mild'],
            ['name' => 'Pollen', 'severity' => 'Mild'],
            ['name' => 'Milk', 'severity' => 'Moderate'],
            ['name' => 'Eggs', 'severity' => 'Mild'],
            ['name' => 'Soy', 'severity' => 'Moderate'],
            ['name' => 'Wheat', 'severity' => 'Mild'],
        ];

        foreach ($students as $student) {
            // 30% chance of having allergies
            if (rand(1, 100) <= 30) {
                $numAllergies = rand(1, 3);
                $selectedAllergies = array_rand($allergies, $numAllergies);
                
                if (!is_array($selectedAllergies)) {
                    $selectedAllergies = [$selectedAllergies];
                }
                
                foreach ($selectedAllergies as $index) {
                    Allergy::create([
                        'student_id' => $student->id,
                        'allergy_name' => $allergies[$index]['name'],
                        'severity' => $allergies[$index]['severity'],
                        'notes' => 'Recorded during health screening'
                    ]);
                }
            }
        }
    }
}