<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestClinicStaffUserSeeder extends Seeder
{
    public function run()
    {
        // Check if clinic staff user already exists
        $user = User::where('email', 'nurse@pdmhs.edu.ph')->first();
        
        if ($user) {
            // Update existing user
            $user->password = Hash::make('nurse123');
            $user->role = 'clinic_staff';
            $user->save();
            echo "Updated existing clinic staff user: {$user->email} with password: nurse123\n";
        } else {
            // Create new clinic staff user
            $user = User::create([
                'name' => 'Maria Santos',
                'email' => 'nurse@pdmhs.edu.ph',
                'password' => Hash::make('nurse123'),
                'role' => 'clinic_staff'
            ]);
            echo "Created new clinic staff user: {$user->email} with password: nurse123\n";
        }
    }
}