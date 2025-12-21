<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            AdviserSeeder::class,
            ImmunizationSeeder::class,
            ClinicVisitSeeder::class,
            HealthIncidentSeeder::class,
            VitalsSeeder::class,
        ]);
    }
}
