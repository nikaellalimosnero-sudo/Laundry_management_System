@extends('layouts.app')

@section('title', 'Register Student')
@section('page-title', 'Register Student')

@section('content')
<div class="mb-4">
    <a href="/admin/students" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i>Back to Students
    </a>
</div>

<div class="card" style="max-width: 620px;">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/admin/students">
            @csrf
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" required placeholder="Juan dela Cruz">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Student ID <span class="text-danger">*</span></label>
                    <input type="text" name="student_id" class="form-control"
                           value="{{ old('student_id') }}" required placeholder="2021-00001">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" required placeholder="student@email.com">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                    <select name="course" class="form-select" required>
                        <option value="">-- Select Course --</option>
                        @foreach(['BSIT','BSCS','BSIS','BSEd','BSBA','BSN','BSECE','BSME','BSCE','BSA'] as $course)
                            <option value="{{ $course }}" {{ old('course') == $course ? 'selected' : '' }}>
                                {{ $course }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Year Level <span class="text-danger">*</span></label>
                    <select name="year_level" class="form-select" required>
                        <option value="">-- Select Year --</option>
                        @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $year)
                            <option value="{{ $year }}" {{ old('year_level') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Number</label>
                    <input type="text" name="contact" class="form-control"
                           value="{{ old('contact') }}" placeholder="09XXXXXXXXX">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Password <span class="text-danger">*</span>
                        <small class="text-muted fw-normal">(student will use this to login)</small>
                    </label>
                    <input type="text" name="password" class="form-control"
                           value="{{ old('password') }}" required placeholder="e.g. Student@2024">
                </div>

                <div class="col-12">
                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        The student will log in at the <strong>Student Portal</strong> using their email and the password you set here.
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-person-check me-2"></i>Register Student
                    </button>
                    <a href="/admin/students" class="btn btn-outline-secondary">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection