<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::find(7); // Student Two
if ($user) {
    echo "User ID: {$user->id}\n";
    echo "User Name: {$user->name}\n";
    echo "User Role: {$user->role}\n";
    echo "User Student ID: {$user->student_id}\n";
} else {
    echo "User not found\n";
}
