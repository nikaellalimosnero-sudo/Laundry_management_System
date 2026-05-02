@extends('layouts.app')

@section('title', 'Register Counselor')
@section('page-title', 'Register Counselor')

@section('content')
<div class="mb-4">
    <a href="/admin/counselors" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i>Back to Counselors
    </a>
</div>

<div class="card" style="max-width: 520px;">
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

        <form method="POST" action="/admin/counselors">
            @csrf
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" required placeholder="Ma. Santos">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" required placeholder="counselor@email.com">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Number</label>
                    <input type="text" name="contact" class="form-control"
                           value="{{ old('contact') }}" placeholder="09XXXXXXXXX">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Password <span class="text-danger">*</span>
                        <small class="text-muted fw-normal">(counselor will use this to login)</small>
                    </label>
                    <input type="text" name="password" class="form-control"
                           value="{{ old('password') }}" required placeholder="e.g. Counselor@2024">
                </div>

                <div class="col-12">
                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        The counselor will log in at the <strong>Counselor Portal</strong> using their email and the password you set here.
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-person-check me-2"></i>Register Counselor
                    </button>
                    <a href="/admin/counselors" class="btn btn-outline-secondary">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection