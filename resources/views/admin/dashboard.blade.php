{{-- This extends (inherits) the main layout --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h2 class="fw-bold mb-1">Admin Dashboard</h2>
<p class="text-muted mb-4">Welcome back, {{ auth()->user()->name }}!</p>

{{-- ── Stat Cards Row ── --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card stat-card h-100 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Students</div>
                    <div class="fs-2 fw-bold text-primary">{{ $stats['students'] }}</div>
                </div>
                <i class="bi bi-people fs-1 text-primary opacity-25"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Counselors</div>
                    <div class="fs-2 fw-bold text-success">{{ $stats['counselors'] }}</div>
                </div>
                <i class="bi bi-person-badge fs-1 text-success opacity-25"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Pending Sessions</div>
                    <div class="fs-2 fw-bold text-warning">{{ $stats['pendingSessions'] }}</div>
                </div>
                <i class="bi bi-clock fs-1 text-warning opacity-25"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Completed Sessions</div>
                    <div class="fs-2 fw-bold text-info">{{ $stats['completedSessions'] }}</div>
                </div>
                <i class="bi bi-check-circle fs-1 text-info opacity-25"></i>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="card">
    <div class="card-header fw-semibold">Quick Actions</div>
    <div class="card-body">
        <div class="d-flex gap-3 flex-wrap">
            <a href="/admin/students/create" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i>Register Student
            </a>
            <a href="/admin/sessions" class="btn btn-outline-primary">
                <i class="bi bi-calendar-plus me-2"></i>Schedule Session
            </a>
            <a href="/admin/reports" class="btn btn-outline-secondary">
                <i class="bi bi-bar-chart me-2"></i>View Reports
            </a>
        </div>
    </div>
</div>
@endsection
