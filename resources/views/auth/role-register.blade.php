<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as {{ ucfirst($role) }} — Counseling System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    @php
        $themes = [
            'admin' => [
                'gradient' => 'linear-gradient(135deg, #7b1a1a 0%, #c0392b 50%, #e74c3c 100%)',
                'accent'   => '#e74c3c',
                'icon'     => 'bi-shield-lock-fill',
                'label'    => 'Administrator',
                'desc'     => 'Create your admin account.',
                'bg'       => '#1a0808',
            ],
            'counselor' => [
                'gradient' => 'linear-gradient(135deg, #0d3d26 0%, #1a6b4a 50%, #27ae60 100%)',
                'accent'   => '#2ecc71',
                'icon'     => 'bi-person-badge-fill',
                'label'    => 'Counselor',
                'desc'     => 'Create your counselor account.',
                'bg'       => '#071a0f',
            ],
            'student' => [
                'gradient' => 'linear-gradient(135deg, #0d1f3c 0%, #1a3c6e 50%, #2980b9 100%)',
                'accent'   => '#5dade2',
                'icon'     => 'bi-mortarboard-fill',
                'label'    => 'Student',
                'desc'     => 'Create your student account with your school information.',
                'bg'       => '#070d1a',
            ],
        ];
        $t = $themes[$role];
    @endphp

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: {{ $t['bg'] }}; min-height: 100vh; display: flex; align-items: stretch; }

        .left-panel {
            width: 38%; background: {{ $t['gradient'] }};
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 3rem; position: relative; overflow: hidden;
        }
        .left-panel::before { content: ''; position: absolute; width: 500px; height: 500px; border-radius: 50%; background: rgba(255,255,255,0.05); top: -150px; right: -150px; }
        .left-panel::after  { content: ''; position: absolute; width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,0.05); bottom: -80px; left: -80px; }

        .panel-back { display: inline-flex; align-items: center; gap: 0.4rem; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.85rem; transition: color 0.2s; position: relative; z-index: 1; }
        .panel-back:hover { color: #fff; }
        .panel-content { position: relative; z-index: 1; }
        .panel-role-icon { width: 72px; height: 72px; background: rgba(255,255,255,0.15); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 32px; color: white; margin-bottom: 1.5rem; }
        .panel-title { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 3.5vw, 2.8rem); color: #fff; line-height: 1.1; margin-bottom: 0.75rem; }
        .panel-desc { color: rgba(255,255,255,0.65); font-size: 0.9rem; line-height: 1.7; }
        .panel-footer { position: relative; z-index: 1; color: rgba(255,255,255,0.3); font-size: 0.8rem; }

        .right-panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2.5rem 2rem; background: {{ $t['bg'] }}; overflow-y: auto; }
        .form-box { width: 100%; max-width: 460px; animation: slideIn 0.5s ease both; }

        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

        .form-heading { font-family: 'Playfair Display', serif; font-size: 1.9rem; color: #fff; margin-bottom: 0.25rem; }
        .form-subheading { color: rgba(255,255,255,0.35); font-size: 0.9rem; margin-bottom: 2rem; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 0; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group + .form-group { margin-top: 0; }
        .form-stack { display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1rem; }

        label { display: block; font-size: 0.78rem; font-weight: 500; color: rgba(255,255,255,0.5); letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 0.45rem; }

        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); font-size: 1rem; pointer-events: none; }

        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; color: #fff; font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem; transition: border-color 0.2s, background 0.2s; outline: none; appearance: none;
        }
        select option { background: #1a1a1a; color: #fff; }
        input:focus, select:focus { border-color: {{ $t['accent'] }}; background: rgba(255,255,255,0.09); }
        input::placeholder { color: rgba(255,255,255,0.2); }

        .section-label {
            font-size: 0.75rem; font-weight: 600; color: {{ $t['accent'] }};
            text-transform: uppercase; letter-spacing: 0.1em;
            margin: 1.5rem 0 1rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .section-label::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08); }

        .error-box {
            background: rgba(231,76,60,0.12); border: 1px solid rgba(231,76,60,0.3);
            border-radius: 10px; padding: 0.85rem 1rem; color: #e74c3c;
            font-size: 0.85rem; margin-bottom: 1.5rem;
        }
        .error-box ul { margin: 0.3rem 0 0 1.1rem; line-height: 1.8; }

        .btn-register {
            width: 100%; padding: 0.9rem; background: {{ $t['gradient'] }};
            border: none; border-radius: 10px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 500;
            cursor: pointer; transition: opacity 0.2s, transform 0.2s; margin-top: 1.5rem;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-register:hover { opacity: 0.88; transform: translateY(-1px); }

        .divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
        .divider span { color: rgba(255,255,255,0.25); font-size: 0.8rem; }

        .btn-login-link {
            width: 100%; padding: 0.85rem; background: transparent;
            border: 1px solid rgba(255,255,255,0.12); border-radius: 10px;
            color: rgba(255,255,255,0.55); font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem; cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            text-decoration: none;
        }
        .btn-login-link:hover { border-color: {{ $t['accent'] }}; color: {{ $t['accent'] }}; }

        @media (max-width: 768px) { .left-panel { display: none; } .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="left-panel">
    <a href="/login/{{ $role }}" class="panel-back"><i class="bi bi-arrow-left"></i> Back to Login</a>
    <div class="panel-content">
        <div class="panel-role-icon"><i class="bi {{ $t['icon'] }}"></i></div>
        <div class="panel-title">Create<br>{{ $t['label'] }}<br>Account</div>
        <p class="panel-desc">{{ $t['desc'] }}</p>
    </div>
    <div class="panel-footer">Student Counseling Management System</div>
</div>

<div class="right-panel">
    <div class="form-box">

        <div class="form-heading">Create Account</div>
        <div class="form-subheading">Register as a {{ $t['label'] }}</div>

        @if($errors->any())
            <div class="error-box">
                <strong><i class="bi bi-exclamation-circle"></i> Please fix the following:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            {{-- ══ STUDENT fields ══════════════════════════════════════════ --}}
            @if($role === 'student')

                <div class="section-label">Personal Information</div>
                <div class="form-stack">
                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="input-wrap">
                            <i class="bi bi-person"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan dela Cruz" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Contact Number <span style="color:rgba(255,255,255,0.25)">(optional)</span></label>
                        <div class="input-wrap">
                            <i class="bi bi-phone"></i>
                            <input type="text" name="contact" value="{{ old('contact') }}" placeholder="09XXXXXXXXX">
                        </div>
                    </div>
                </div>

                <div class="section-label">School Information</div>
                <div class="form-stack">
                    <div class="form-group">
                        <label>Student ID</label>
                        <div class="input-wrap">
                            <i class="bi bi-card-text"></i>
                            <input type="text" name="student_id" value="{{ old('student_id') }}" placeholder="e.g. 2021-00001" required>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Course</label>
                            <div class="input-wrap">
                                <i class="bi bi-book"></i>
                                <select name="course" required>
                                    <option value="">-- Select --</option>
                                    @foreach(['BSIT','BSCS','BSIS','BSEd','BSBA','BSN','BSECE','BSME','BSCE','BSA'] as $c)
                                        <option value="{{ $c }}" {{ old('course') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Year Level</label>
                            <div class="input-wrap">
                                <i class="bi bi-layers"></i>
                                <select name="year_level" required>
                                    <option value="">-- Select --</option>
                                    @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $y)
                                        <option value="{{ $y }}" {{ old('year_level') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-label">Account Credentials</div>
                <div class="form-stack">
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" placeholder="Minimum 8 characters" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="password_confirmation" placeholder="Repeat your password" required>
                        </div>
                    </div>
                </div>

            {{-- ══ COUNSELOR fields ════════════════════════════════════════ --}}
            @elseif($role === 'counselor')

                <div class="form-stack">
                    <div class="form-group">
                        <label>Full Name</label>
                        <div class="input-wrap">
                            <i class="bi bi-person"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ma. Santos" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Contact Number <span style="color:rgba(255,255,255,0.25)">(optional)</span></label>
                        <div class="input-wrap">
                            <i class="bi bi-phone"></i>
                            <input type="text" name="contact" value="{{ old('contact') }}" placeholder="09XXXXXXXXX">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" placeholder="Minimum 8 characters" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="password_confirmation" placeholder="Repeat your password" required>
                        </div>
                    </div>
                </div>

            {{-- ══ ADMIN fields ════════════════════════════════════════════ --}}
            @else

                <div class="form-stack">
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" placeholder="Minimum 8 characters" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="password_confirmation" placeholder="Repeat your password" required>
                        </div>
                    </div>
                </div>

            @endif

            <button type="submit" class="btn-register">
                <i class="bi bi-person-check-fill"></i> Create Account
            </button>
        </form>

        <div class="divider"><span>or</span></div>

        <a href="/login/{{ $role }}" class="btn-login-link">
            <i class="bi bi-box-arrow-in-right"></i> Already have an account? Sign In
        </a>

    </div>
</div>

</body>
</html>