@extends('layouts.app')

@section('title', 'Edit Clinic Visit')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Clinic Visit</h1>
                    <a href="{{ route('clinic.visits.show', $clinicVisit) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Cancel
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('clinic.visits.update', $clinicVisit) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Visit Information -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Visit Information</h2>

                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student *</label>
                            <select name="student_id" id="student_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a student</option>
                                @foreach($students ?? [] as $student)
                                    <option value="{{ $student->id }}" {{ $clinicVisit->student_id == $student->id ? 'selected' : '' }}>
                                        {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visit Date & Time *</label>
                            <input type="datetime-local" name="visit_date" id="visit_date" required
                                   value="{{ $clinicVisit->visit_date->format('Y-m-d\TH:i') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('visit_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reason_for_visit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Visit *</label>
                            <textarea name="reason_for_visit" id="reason_for_visit" rows="3" required
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $clinicVisit->reason_for_visit }}</textarea>
                            @error('reason_for_visit')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="symptoms" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Symptoms</label>
                            <textarea name="symptoms" id="symptoms" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $clinicVisit->symptoms }}</textarea>
                            @error('symptoms')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pending" {{ $clinicVisit->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $clinicVisit->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $clinicVisit->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $clinicVisit->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Medical Assessment -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Medical Assessment</h2>

                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diagnosis</label>
                            <textarea name="diagnosis" id="diagnosis" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $clinicVisit->diagnosis }}</textarea>
                            @error('diagnosis')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="treatment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Treatment</label>
                            <textarea name="treatment" id="treatment" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $clinicVisit->treatment }}</textarea>
                            @error('treatment')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="medications" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medications Prescribed</label>
                            <textarea name="medications" id="medications" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $clinicVisit->medications }}</textarea>
                            @error('medications')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="follow_up_required" id="follow_up_required" value="1"
                                   {{ $clinicVisit->follow_up_required ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <label for="follow_up_required" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Follow-up Required
                            </label>
                        </div>

                        <div>
                            <label for="follow_up_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Follow-up Date</label>
                            <input type="date" name="follow_up_date" id="follow_up_date"
                                   value="{{ $clinicVisit->follow_up_date ? $clinicVisit->follow_up_date->format('Y-m-d') : '' }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('follow_up_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $clinicVisit->notes }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <a href="{{ route('clinic.visits.show', $clinicVisit) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                        Update Clinic Visit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
