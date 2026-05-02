@extends('layouts.app')

@section('title', 'Manage Students')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Students</h2>
        <p class="text-muted mb-0">Manage registered students</p>
    </div>
    <a href="/admin/students/create" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Register Student
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through each student --}}
                @forelse($students as $student)
                <tr>
                    <td><span class="badge bg-secondary">{{ $student->student_id }}</span></td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->year_level }}</td>
                    <td>{{ $student->contact ?? '—' }}</td>
                    <td>
                        {{-- Delete button with confirmation --}}
                        <form method="POST" action="/admin/students/{{ $student->id }}"
                              onsubmit="return confirm('Delete {{ $student->name }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')  {{-- HTML forms only support GET/POST; this spoofs DELETE --}}
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    {{-- Shown when there are no students --}}
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No students registered yet.
                            <a href="/admin/students/create">Register one now!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
