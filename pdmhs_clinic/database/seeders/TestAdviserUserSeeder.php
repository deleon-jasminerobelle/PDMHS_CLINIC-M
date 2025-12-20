<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Adviser;
use Illuminate\Support\Facades\Hash;

class TestAdviserUserSeeder extends Seeder
{
    public function run()
    {
        // Check if adviser user already exists
        $user = User::where('email', 'adviser@pdmhs.edu.ph')->first();
        
        if ($user) {
            // Update existing user
            $user->password = Hash::make('adviser123');
            $user->role = 'adviser';
            $user->save();
            echo "Updated existing adviser user: {$user->email} with password: adviser123\n";
        } else {
            // Create new adviser user
            $user = User::create([
                'name' => 'Maria Santos',
                'email' => 'adviser@pdmhs.edu.ph',
                'password' => Hash::make('adviser123'),
                'role' => 'adviser'
            ]);
            echo "Created new adviser user: {$user->email} with password: adviser123\n";
        }

        // Check if adviser record exists
        $adviser = Adviser::where('user_id', $user->id)->first();
        
        if (!$adviser) {
            // Create adviser record if it doesn't exist
            $adviser = Adviser::create([
                'user_id' => $user->id,
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'employee_number' => 'ADV-001',
                'contact_phone' => '09123456789'
            ]);
            echo "Created adviser record: {$adviser->first_name} {$adviser->last_name}\n";
        } else {
            echo "Adviser record already exists: {$adviser->first_name} {$adviser->last_name}\n";
        }
    }
}