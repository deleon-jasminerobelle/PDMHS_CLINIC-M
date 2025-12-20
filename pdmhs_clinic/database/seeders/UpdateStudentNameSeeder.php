<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateStudentNameSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'student@pdmhs.edu.ph')->first();
        
        if ($user) {
            $user->name = 'Clarence Villas';
            $user->save();
            echo "Updated student user name to: {$user->name}\n";
        } else {
            echo "Student user not found\n";
        }
    }
}