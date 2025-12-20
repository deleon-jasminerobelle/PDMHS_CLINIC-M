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
<<<<<<< HEAD
            StudentSeeder::class,
            ImmunizationSeeder::class,
            ClinicVisitSeeder::class,
            HealthIncidentSeeder::class,
=======
            AdviserSeeder::class,
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
        ]);
    }
}
