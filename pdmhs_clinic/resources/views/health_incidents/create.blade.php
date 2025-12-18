@extends('layouts.app')

@section('title', 'Report Health Incident')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Report Health Incident</h1>
                    <a href="{{ route('health-incidents.index') }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">← Back to Health Incidents</a>
                </div>

