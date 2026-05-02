@extends('layouts.app')

@section('title', 'Manage Sessions')

@section('content')
<h2 class="fw-bold mb-1">Counseling Sessions</h2>
<p class="text-muted mb-4">Schedule and manage all counseling sessions</p>

{{-- ── Schedule New Session Form ── --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        <i class="bi bi-calendar-plus me-2"></i>Schedule New Session
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/admin/sessions">
            @csrf
            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} ({{ $student->student_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Counselor</label>
                    <select name="counselor_id" class="form-select" required>
                        <option value="">-- Select Counselor --</option>
                        @foreach($counselors as $counselor)
                            <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Concern</label>
                    <input type="text" name="concern" class="form-control" placeholder="e.g. Academic">
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ── Sessions Table ── --}}
<div class="card">
    <div class="card-header fw-semibold">All Sessions</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Counselor</th>
                    <th>Scheduled</th>
                    <th>Concern</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->student->name }}</td>
                    <td>{{ $session->counselor->name }}</td>
                    <td>{{ $session->scheduled_at->format('M d, Y h:i A') }}</td>
                    <td>{{ $session->concern ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $session->statusBadge() }}">
                            {{ ucfirst($session->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No sessions yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
