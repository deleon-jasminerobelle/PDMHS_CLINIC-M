<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateStudentPasswordSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'juan.dela cruz@student.pdmhs.edu')->first();
        
        if ($user) {
            $user->email = 'student@pdmhs.edu.ph';
            $user->password = Hash::make('student123');
            $user->save();
            echo "Email and password updated for user: {$user->email}\n";
        } else {
            echo "User not found\n";
        }
    }
}