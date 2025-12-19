<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateStudentEmailSeeder extends Seeder
{
    public function run()
    {
        // First, let's see what users exist
        $users = User::where('role', 'student')->get();
        echo "Current student users:\n";
        foreach ($users as $user) {
            echo "ID: {$user->id}, Email: {$user->email}, Name: {$user->name}\n";
        }
        
        // Update the user with the old email to the new one
        $user = User::where('email', 'juan.dela cruz@student.pdmhs.edu')->first();
        
        if ($user) {
            // Check if the target email already exists
            $existingUser = User::where('email', 'student@pdmhs.edu.ph')->first();
            if ($existingUser) {
                echo "User with email student@pdmhs.edu.ph already exists. Updating that user instead.\n";
                $existingUser->password = Hash::make('student123');
                $existingUser->save();
                echo "Password updated for existing user: {$existingUser->email}\n";
            } else {
                $user->email = 'student@pdmhs.edu.ph';
                $user->password = Hash::make('student123');
                $user->save();
                echo "Email and password updated for user: {$user->email}\n";
            }
        } else {
            echo "Original user not found\n";
        }
    }
}