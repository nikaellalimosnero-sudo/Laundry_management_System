@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<h2 class="fw-bold mb-1">Hello, {{ auth()->user()->name }}!</h2>
<p class="text-muted mb-4">Here's your counseling session overview.</p>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card stat-card border-primary h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Upcoming Sessions</div>
                    <div class="fs-2 fw-bold text-primary">{{ $stats['upcoming'] }}</div>
                </div>
                <i class="bi bi-calendar-event fs-1 text-primary opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stat-card border-success h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Completed Sessions</div>
                    <div class="fs-2 fw-bold text-success">{{ $stats['completed'] }}</div>
                </div>
                <i class="bi bi-check-circle fs-1 text-success opacity-25"></i>
            </div>
        </div>
    </div>
</div>

{{-- Next Session --}}
@if($nextSession)
<div class="card border-primary">
    <div class="card-header bg-primary text-white fw-semibold">
        <i class="bi bi-alarm me-2"></i>Your Next Session
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Counselor</div>
                <div class="fw-semibold">{{ $nextSession->counselor->name }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Date & Time</div>
                <div class="fw-semibold">{{ $nextSession->scheduled_at->format('M d, Y h:i A') }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Concern</div>
                <div class="fw-semibold">{{ $nextSession->concern ?? '—' }}</div>
            </div>
        </div>
        <div class="mt-3">
            <a href="/student/sessions" class="btn btn-outline-primary btn-sm">View All Sessions</a>
        </div>
    </div>
</div>
@else
<div class="card border-0 bg-light">
    <div class="card-body text-center text-muted py-4">
        <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
        No upcoming sessions scheduled.
    </div>
</div>
@endif
@endsection
