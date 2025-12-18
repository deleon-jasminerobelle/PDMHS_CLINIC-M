@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Add Immunization Record</h1>
            <a href="{{ route('immunizations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">New Immunization Record</h2>
            </div>

            <form method="POST" action="{{ route('immunizations.store') }}" class="p-6">
                @csrf

                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('student_id') border-red-500 @enderror" required>
                        <option value="">Select a student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="vaccine_name" class="block text-sm font-medium text-gray-700 mb-2">Vaccine Name</label>
                    <input type="text" name="vaccine_name" id="vaccine_name" value="{{ old('vaccine_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('vaccine_name') border-red-500 @enderror" required>
                    @error('vaccine_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date_administered" class="block text-sm font-medium text-gray-700 mb-2">Date Administered</label>
                    <input type="date" name="date_administered" id="date_administered" value="{{ old('date_administered') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('date_administered') border-red-500 @enderror" required>
                    @error('date_administered')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="next_due_date" class="block text-sm font-medium text-gray-700 mb-2">Next Due Date</label>
                    <input type="date" name="next_due_date" id="next_due_date" value="{{ old('next_due_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('next_due_date') border-red-500 @enderror">
                    @error('next_due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="administered_by" class="block text-sm font-medium text-gray-700 mb-2">Administered By</label>
                    <input type="text" name="administered_by" id="administered_by" value="{{ old('administered_by') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('administered_by') border-red-500 @enderror">
                    @error('administered_by')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-2">Batch Number</label>
                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('batch_number') border-red-500 @enderror">
                    @error('batch_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Save Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
