<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($role) }} Login — Counseling System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    @php
        $themes = [
            'admin' => [
                'gradient' => 'linear-gradient(135deg, #7b1a1a 0%, #c0392b 50%, #e74c3c 100%)',
                'accent'   => '#e74c3c',
                'icon'     => 'bi-shield-lock-fill',
                'label'    => 'Administrator',
                'desc'     => 'System management & oversight.',
                'bg'       => '#1a0808',
            ],
            'counselor' => [
                'gradient' => 'linear-gradient(135deg, #0d3d26 0%, #1a6b4a 50%, #27ae60 100%)',
                'accent'   => '#2ecc71',
                'icon'     => 'bi-person-badge-fill',
                'label'    => 'Counselor',
                'desc'     => 'Session management & student support.',
                'bg'       => '#071a0f',
            ],
            'student' => [
                'gradient' => 'linear-gradient(135deg, #0d1f3c 0%, #1a3c6e 50%, #2980b9 100%)',
                'accent'   => '#5dade2',
                'icon'     => 'bi-mortarboard-fill',
                'label'    => 'Student',
                'desc'     => 'View sessions & counseling records.',
                'bg'       => '#070d1a',
            ],
        ];
        $t = $themes[$role];
    @endphp

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: {{ $t['bg'] }}; min-height: 100vh; display: flex; align-items: stretch; }

        .left-panel {
            width: 45%; background: {{ $t['gradient'] }};
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 3rem; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; width: 500px; height: 500px;
            border-radius: 50%; background: rgba(255,255,255,0.05); top: -150px; right: -150px;
        }
        .left-panel::after {
            content: ''; position: absolute; width: 300px; height: 300px;
            border-radius: 50%; background: rgba(255,255,255,0.05); bottom: -80px; left: -80px;
        }
        .panel-back {
            display: inline-flex; align-items: center; gap: 0.4rem;
            color: rgba(255,255,255,0.7); text-decoration: none;
            font-size: 0.85rem; transition: color 0.2s; position: relative; z-index: 1;
        }
        .panel-back:hover { color: #fff; }
        .panel-content { position: relative; z-index: 1; }
        .panel-role-icon {
            width: 72px; height: 72px; background: rgba(255,255,255,0.15);
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: white; margin-bottom: 1.5rem;
        }
        .panel-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); color: #fff; line-height: 1.1; margin-bottom: 0.75rem; }
        .panel-desc { color: rgba(255,255,255,0.65); font-size: 0.95rem; line-height: 1.7; max-width: 300px; }
        .panel-footer { position: relative; z-index: 1; color: rgba(255,255,255,0.3); font-size: 0.8rem; }

        .right-panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 3rem 2rem; background: {{ $t['bg'] }}; }
        .form-box { width: 100%; max-width: 400px; animation: slideIn 0.5s ease both; }

        @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

        .form-heading { font-family: 'Playfair Display', serif; font-size: 1.9rem; color: #fff; margin-bottom: 0.25rem; }
        .form-subheading { color: rgba(255,255,255,0.35); font-size: 0.9rem; margin-bottom: 2.5rem; }

        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.78rem; font-weight: 500; color: rgba(255,255,255,0.5); letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 0.5rem; }

        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.3); font-size: 1rem; pointer-events: none; }

        input[type="email"], input[type="password"] {
            width: 100%; padding: 0.85rem 1rem 0.85rem 2.75rem;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; color: #fff; font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem; transition: border-color 0.2s, background 0.2s; outline: none;
        }
        input:focus { border-color: {{ $t['accent'] }}; background: rgba(255,255,255,0.09); }
        input::placeholder { color: rgba(255,255,255,0.2); }

        .error-box {
            background: rgba(231,76,60,0.12); border: 1px solid rgba(231,76,60,0.3);
            border-radius: 10px; padding: 0.85rem 1rem; color: #e74c3c;
            font-size: 0.88rem; margin-bottom: 1.5rem;
            display: flex; align-items: flex-start; gap: 0.6rem;
        }
        .success-box {
            background: rgba(46,204,113,0.1); border: 1px solid rgba(46,204,113,0.3);
            border-radius: 10px; padding: 0.85rem 1rem; color: #2ecc71;
            font-size: 0.88rem; margin-bottom: 1.5rem;
        }

        .btn-login {
            width: 100%; padding: 0.9rem; background: {{ $t['gradient'] }};
            border: none; border-radius: 10px; color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 500;
            cursor: pointer; transition: opacity 0.2s, transform 0.2s; margin-top: 0.5rem;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-login:hover { opacity: 0.88; transform: translateY(-1px); }

        .divider { display: flex; align-items: center; gap: 1rem; margin: 1.75rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
        .divider span { color: rgba(255,255,255,0.25); font-size: 0.8rem; }

        .btn-register {
            width: 100%; padding: 0.85rem; background: transparent;
            border: 1px solid rgba(255,255,255,0.12); border-radius: 10px;
            color: rgba(255,255,255,0.6); font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem; cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            text-decoration: none;
        }
        .btn-register:hover { border-color: {{ $t['accent'] }}; color: {{ $t['accent'] }}; }

        .hint-box {
            margin-top: 1.5rem; padding: 0.85rem 1rem;
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px; font-size: 0.82rem; color: rgba(255,255,255,0.3);
            line-height: 1.7;
        }

        @media (max-width: 768px) { .left-panel { display: none; } }
    </style>
</head>
<body>

<div class="left-panel">
    <a href="/" class="panel-back"><i class="bi bi-arrow-left"></i> All Portals</a>
    <div class="panel-content">
        <div class="panel-role-icon"><i class="bi {{ $t['icon'] }}"></i></div>
        <div class="panel-title">{{ $t['label'] }}<br>Portal</div>
        <p class="panel-desc">{{ $t['desc'] }} Sign in with your registered credentials to continue.</p>
    </div>
    <div class="panel-footer">Student Counseling Management System</div>
</div>

<div class="right-panel">
    <div class="form-box">

        <div class="form-heading">Welcome back</div>
        <div class="form-subheading">Sign in to your {{ $t['label'] }} account</div>

        @if($errors->any())
            <div class="error-box">
                <i class="bi bi-exclamation-circle-fill" style="margin-top:2px; flex-shrink:0;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="success-box"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error-box">
                <i class="bi bi-exclamation-circle-fill" style="flex-shrink:0;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="your@email.com" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Sign In
            </button>
        </form>

        @if($role !== 'admin')
        <div class="divider"><span>or</span></div>
        <a href="/register/{{ $role }}" class="btn-register">
            <i class="bi bi-person-plus"></i> Create a new {{ $t['label'] }} account
        </a>
        @endif

        {{-- Helpful hint for students registered by admin --}}
        @if($role === 'student')
        <div class="hint-box">
            <i class="bi bi-info-circle me-1"></i>
            If your school already registered your account, just sign in directly — no need to create a new one.
        </div>
        @endif

        @if($role === 'counselor')
        <div class="hint-box">
            <i class="bi bi-info-circle me-1"></i>
            If the admin already created your account, sign in directly with the credentials provided to you.
        </div>
        @endif

    </div>
</div>

</body>
</html>