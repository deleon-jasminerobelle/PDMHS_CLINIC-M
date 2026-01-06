<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Users with clinic_staff role:\n";
$clinicStaffUsers = \App\Models\User::where('role', 'clinic_staff')->get();
foreach ($clinicStaffUsers as $user) {
    echo $user->id . ': ' . $user->email . ' - ' . $user->name . "\n";
}

echo "\nAll users:\n";
$allUsers = \App\Models\User::all();
foreach ($allUsers as $user) {
    echo $user->id . ': ' . $user->email . ' - ' . $user->name . ' (' . $user->role . ")\n";
}
