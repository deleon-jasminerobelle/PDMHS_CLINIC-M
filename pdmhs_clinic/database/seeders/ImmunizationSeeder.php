<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Immunization;

class ImmunizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Immunization::create([
            'student_id' => 1,
            'vaccine_name' => 'MMR',
            'date_administered' => '2023-09-01',
            'next_due_date' => '2028-09-01',
            'administered_by' => 'Dr. Smith',
            'batch_number' => 'BATCH001',
            'notes' => 'First dose of MMR vaccine.',
        ]);

        Immunization::create([
            'student_id' => 2,
            'vaccine_name' => 'DTaP',
            'date_administered' => '2023-08-15',
            'next_due_date' => '2028-08-15',
            'administered_by' => 'Nurse Johnson',
            'batch_number' => 'BATCH002',
            'notes' => 'Booster dose.',
        ]);

        Immunization::create([
            'student_id' => 3,
            'vaccine_name' => 'Polio',
            'date_administered' => '2023-10-01',
            'next_due_date' => '2028-10-01',
            'administered_by' => 'Dr. Brown',
            'batch_number' => 'BATCH003',
            'notes' => 'Oral polio vaccine.',
        ]);
    }
}
