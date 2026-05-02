@extends('layouts.app')

@section('title', 'Session Notes')

@section('content')
<div class="mb-4">
    <a href="/counselor/sessions" class="text-muted text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Back to Sessions
    </a>
    <h2 class="fw-bold mb-0 mt-1">Session Notes</h2>
</div>

{{-- Session Info Card --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="text-muted small">Student</div>
                <div class="fw-semibold">{{ $session->student->name }}</div>
                <div class="small text-muted">{{ $session->student->student_id }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Scheduled</div>
                <div class="fw-semibold">{{ $session->scheduled_at->format('M d, Y h:i A') }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Concern</div>
                <div class="fw-semibold">{{ $session->concern ?? '—' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Notes Form --}}
<div class="card" style="max-width: 600px;">
    <div class="card-header fw-semibold">
        <i class="bi bi-journal-text me-2"></i>
        @if($session->status === 'completed') View Notes @else Update Session Notes @endif
    </div>
    <div class="card-body">
        <form method="POST" action="/counselor/sessions/{{ $session->id }}/notes">
            @csrf
            <div class="mb-3">
                <label class="form-label">Session Notes <span class="text-danger">*</span></label>
                <textarea name="notes" class="form-control" rows="6"
                          placeholder="Write your observations, recommendations, and follow-up plans here..."
                          {{ $session->status === 'completed' ? 'readonly' : '' }}
                          required>{{ old('notes', $session->notes) }}</textarea>
            </div>

            @if($session->status !== 'completed')
                <div class="alert alert-info small py-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Saving notes will mark this session as <strong>Completed</strong>.
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Save & Complete Session
                    </button>
                    <a href="/counselor/sessions" class="btn btn-outline-secondary">Cancel</a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
