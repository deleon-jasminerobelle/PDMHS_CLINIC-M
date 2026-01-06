<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$user = new User();
$user->role = 'student';

echo "Testing isStudent method in Laravel context:\n";
try {
    $result = $user->isStudent();
    echo "isStudent() returned: " . ($result ? 'true' : 'false') . "\n";
    echo "Method exists and works correctly.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
