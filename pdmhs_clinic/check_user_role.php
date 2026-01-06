<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking user roles...\n";

$users = \App\Models\User::all();

foreach ($users as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Name: {$user->name}, Role: '{$user->role}' (length: " . strlen($user->role) . ")\n";
    echo "Role bytes: " . implode(' ', array_map('ord', str_split($user->role))) . "\n";
}
