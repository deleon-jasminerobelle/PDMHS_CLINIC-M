@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Clinic Visits</h1>
                <a href="{{ route('clinic-visits.create') }}" class="btn btn-primary">Add New Visit</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Visit Date</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clinicVisits as $visit)
                                    <tr>
                                        <td>{{ $visit->id }}</td>
                                        <td>{{ $visit->student->name ?? 'N/A' }}</td>
                                        <td>{{ $visit->visit_date }}</td>
                                        <td>{{ $visit->reason }}</td>
                                        <td>
                                            <a href="{{ route('clinic-visits.show', $visit) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('clinic-visits.edit', $visit) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('clinic-visits.destroy', $visit) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No clinic visits found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
