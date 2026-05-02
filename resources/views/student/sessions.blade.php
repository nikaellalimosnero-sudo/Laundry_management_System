@extends('layouts.app')

@section('title', 'My Sessions')

@section('content')
<h2 class="fw-bold mb-1">My Sessions</h2>
<p class="text-muted mb-4">View and manage your counseling sessions</p>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Counselor</th>
                    <th>Scheduled</th>
                    <th>Concern</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                <tr>
                    <td>{{ $session->counselor->name }}</td>
                    <td>{{ $session->scheduled_at->format('M d, Y h:i A') }}</td>
                    <td>{{ $session->concern ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $session->statusBadge() }}">
                            {{ ucfirst($session->status) }}
                        </span>
                    </td>
                    <td>
                        @if($session->notes)
                            {{-- Show truncated note, full note shown on hover --}}
                            <span class="small text-muted" title="{{ $session->notes }}">
                                {{ Str::limit($session->notes, 50) }}
                            </span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @if($session->status === 'pending')
                            {{-- Cancel button with confirmation dialog --}}
                            <form method="POST"
                                  action="/student/sessions/{{ $session->id }}/cancel"
                                  onsubmit="return confirm('Are you sure you want to cancel this session?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-calendar-x d-block fs-1 mb-2"></i>
                        No sessions scheduled for you yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
