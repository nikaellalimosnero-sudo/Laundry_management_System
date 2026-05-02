@extends('layouts.app')

@section('title', 'Counselor Dashboard')

@section('content')
<h2 class="fw-bold mb-1">Good day, {{ auth()->user()->name }}!</h2>
<p class="text-muted mb-4">Here's your counseling overview.</p>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-warning h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Upcoming Sessions</div>
                    <div class="fs-2 fw-bold text-warning">{{ $stats['upcoming'] }}</div>
                </div>
                <i class="bi bi-calendar-event fs-1 text-warning opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-primary h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Ongoing</div>
                    <div class="fs-2 fw-bold text-primary">{{ $stats['ongoing'] }}</div>
                </div>
                <i class="bi bi-play-circle fs-1 text-primary opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-success h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Completed</div>
                    <div class="fs-2 fw-bold text-success">{{ $stats['completed'] }}</div>
                </div>
                <i class="bi bi-check-circle fs-1 text-success opacity-25"></i>
            </div>
        </div>
    </div>
</div>

{{-- Upcoming Sessions --}}
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-calendar-week me-2"></i>Upcoming Sessions
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Student</th><th>Date & Time</th><th>Concern</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($upcomingSessions as $session)
                <tr>
                    <td>{{ $session->student->name }}</td>
                    <td>{{ $session->scheduled_at->format('M d, Y h:i A') }}</td>
                    <td>{{ $session->concern ?? '—' }}</td>
                    <td>
                        <a href="/counselor/sessions" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">No upcoming sessions.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
