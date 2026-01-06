<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing route access...\n";

// Test if the clinic-staff.dashboard route exists
try {
    $url = route('clinic-staff.dashboard');
    echo "Route 'clinic-staff.dashboard' exists: $url\n";
} catch (Exception $e) {
    echo "Route 'clinic-staff.dashboard' does not exist: " . $e->getMessage() . "\n";
}

// Test if the login route exists
try {
    $url = route('login');
    echo "Route 'login' exists: $url\n";
} catch (Exception $e) {
    echo "Route 'login' does not exist: " . $e->getMessage() . "\n";
}

// Test if the clinic-staff middleware is registered
$kernel = app(\Illuminate\Contracts\Http\Kernel::class);
$middlewares = $kernel->getMiddlewareGroups();
$routeMiddleware = $kernel->getRouteMiddleware();

echo "Available route middlewares:\n";
foreach ($routeMiddleware as $key => $middleware) {
    echo "  $key => $middleware\n";
}

echo "\nTesting middleware registration...\n";
if (isset($routeMiddleware['clinic.staff'])) {
    echo "clinic.staff middleware is registered\n";
} else {
    echo "clinic.staff middleware is NOT registered\n";
}
