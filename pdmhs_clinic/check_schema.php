<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Students table columns:\n";
$columns = Schema::getColumnListing('students');
print_r($columns);

echo "\nVitals table columns:\n";
$columns = Schema::getColumnListing('vitals');
print_r($columns);

echo "\nHealth incidents table columns:\n";
$columns = Schema::getColumnListing('health_incidents');
print_r($columns);
