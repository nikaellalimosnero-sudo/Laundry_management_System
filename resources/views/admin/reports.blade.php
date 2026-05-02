@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<h2 class="fw-bold mb-1">Session Reports</h2>
<p class="text-muted mb-4">Overview of all counseling sessions</p>

{{-- ── Summary Cards ── --}}
<div class="row g-3 mb-4">
    @php
        $statusColors = [
            'pending'   => 'warning',
            'ongoing'   => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
        $statusIcons = [
            'pending'   => 'clock',
            'ongoing'   => 'play-circle',
            'completed' => 'check-circle',
            'cancelled' => 'x-circle',
        ];
    @endphp

    @foreach($statusColors as $status => $color)
    <div class="col-md-3">
        <div class="card stat-card border-{{ $color }} h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">{{ ucfirst($status) }}</div>
                    <div class="fs-2 fw-bold text-{{ $color }}">
                        {{ $summary[$status] ?? 0 }}
                    </div>
                </div>
                <i class="bi bi-{{ $statusIcons[$status] }} fs-1 text-{{ $color }} opacity-25"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Recent Sessions Table ── --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Recent Sessions</span>
        {{-- Simple print button --}}
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer me-1"></i>Print Report
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Counselor</th>
                    <th>Concern</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSessions as $session)
                <tr>
                    <td>{{ $session->scheduled_at->format('M d, Y') }}</td>
                    <td>{{ $session->student->name }}</td>
                    <td>{{ $session->counselor->name }}</td>
                    <td>{{ $session->concern ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $session->statusBadge() }}">
                            {{ ucfirst($session->status) }}
                        </span>
                    </td>
                    <td>
                        @if($session->notes)
                            <span class="text-muted small" title="{{ $session->notes }}">
                                {{ Str::limit($session->notes, 40) }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No sessions recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
