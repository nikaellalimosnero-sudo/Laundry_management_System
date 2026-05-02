@extends('layouts.app')

@section('title', 'My Sessions')

@section('content')
<h2 class="fw-bold mb-1">My Sessions</h2>
<p class="text-muted mb-4">All sessions assigned to you</p>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Student</th>
                    <th>Scheduled</th>
                    <th>Concern</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                <tr>
                    <td>
                        <strong>{{ $session->student->name }}</strong>
                        <div class="small text-muted">{{ $session->student->student_id }}</div>
                    </td>
                    <td>{{ $session->scheduled_at->format('M d, Y h:i A') }}</td>
                    <td>{{ $session->concern ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $session->statusBadge() }}">
                            {{ ucfirst($session->status) }}
                        </span>
                    </td>
                    <td>
                        @if($session->status === 'pending')
                            {{-- Conduct (Start) Session --}}
                            <form method="POST" action="/counselor/sessions/{{ $session->id }}/conduct" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-primary">
                                    <i class="bi bi-play-fill me-1"></i>Start
                                </button>
                            </form>

                        @elseif($session->status === 'ongoing')
                            {{-- Update Notes --}}
                            <a href="/counselor/sessions/{{ $session->id }}/notes"
                               class="btn btn-sm btn-success">
                                <i class="bi bi-pencil me-1"></i>Add Notes
                            </a>

                        @elseif($session->status === 'completed')
                            <a href="/counselor/sessions/{{ $session->id }}/notes"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye me-1"></i>View Notes
                            </a>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No sessions assigned to you yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
