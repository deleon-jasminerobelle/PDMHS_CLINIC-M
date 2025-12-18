<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/features', function () {
    return view('feature');
})->name('features');

Route::get('/architecture', function () {
    return view('architecture');
})->name('architecture');

Route::get('/scanner', function () {
    return view('scanner');
})->name('scanner');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/student-health-form', function () {
    return view('student-health-form');
})->name('student-health-form');
