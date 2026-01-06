<?php

require_once 'vendor/autoload.php';

use App\Models\User;

$user = new User();
$user->role = 'student';

if ($user->isStudent()) {
    echo "isStudent method works correctly.\n";
} else {
    echo "isStudent method failed.\n";
}
