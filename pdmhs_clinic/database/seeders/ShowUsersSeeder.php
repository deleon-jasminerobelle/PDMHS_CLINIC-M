<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ShowUsersSeeder extends Seeder
{
    public function run()
    {
        echo "Available users:\n";
        echo "================\n";
        
        $users = User::all(['email', 'role', 'name']);
        
        foreach ($users as $user) {
            echo "Email: {$user->email}\n";
            echo "Role: {$user->role}\n";
            echo "Name: {$user->name}\n";
            echo "---\n";
        }
    }
}