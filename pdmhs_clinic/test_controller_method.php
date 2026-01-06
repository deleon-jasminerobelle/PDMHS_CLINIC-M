<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

// Simulate a user
$user = new User();
$user->role = 'student';

echo "Testing isStudent method in controller context:\n";
try {
    $result = $user->isStudent();
    echo "isStudent() returned: " . ($result ? 'true' : 'false') . "\n";
    echo "Method exists and works correctly in Laravel context.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Method signature: " . (method_exists($user, 'isStudent') ? 'exists' : 'does not exist') . "\n";
}
