<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MedicalVisit;

class VitalsSeeder extends Seeder
{
    public function run()
    {
        // Get existing medical visits
        $medicalVisits = MedicalVisit::all();

        foreach ($medicalVisits as $visit) {
            // Generate realistic vitals data
            $age = rand(15, 18); // High school age
            $baseWeight = $age * 3 + rand(35, 55); // Realistic weight for teens
            $baseHeight = rand(150, 180); // Realistic height in cm
            
            DB::table('vitals')->insert([
                'visit_id' => $visit->visit_id,
                'recorded_at' => $visit->visit_datetime,
                'weight_kg' => $baseWeight + rand(-5, 10),
                'height_cm' => $baseHeight,
                'temperature_c' => 36.5 + (rand(-10, 15) / 10), // 36.0 - 38.0°C
                'bp_systolic' => rand(110, 140),
                'bp_diastolic' => rand(70, 90),
                'pulse_rate' => rand(60, 100),
                'respiration_rate' => rand(12, 20),
                'notes' => 'Routine vital signs check'
            ]);
        }
    }
}