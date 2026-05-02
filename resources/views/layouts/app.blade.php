<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Counseling System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    @php
        $role = auth()->user()->role;
        $sidebarThemes = [
            'admin'     => ['from' => '#7b1a1a', 'to' => '#c0392b', 'accent' => '#e74c3c'],
            'counselor' => ['from' => '#0d3d26', 'to' => '#1a6b4a', 'accent' => '#2ecc71'],
            'student'   => ['from' => '#0d1f3c', 'to' => '#1a3c6e', 'accent' => '#5dade2'],
        ];
        $st = $sidebarThemes[$role];
    @endphp

    <style>
        body { background: #f4f6f9; font-family: 'DM Sans', sans-serif; }

        .sidebar {
            min-height: 100vh;
            width: 240px;
            min-width: 240px;
            background: linear-gradient(180deg, {{ $st['from'] }} 0%, {{ $st['to'] }} 100%);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 0.5rem;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: #fff;
            display: block;
        }

        .brand-role {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.45);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .sidebar nav { padding: 1rem 0.75rem; flex: 1; }

        .sidebar a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 0.85rem;
            border-radius: 8px;
            margin-bottom: 2px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .sidebar a:hover { background: rgba(255,255,255,0.12); color: #fff; }

        .sidebar a.active {
            background: rgba(255,255,255,0.18);
            color: #fff;
            font-weight: 500;
        }

        .sidebar a i { font-size: 1rem; opacity: 0.8; }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.75rem;
        }

        .user-avatar {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.85);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-logout {
            width: 100%;
            padding: 0.55rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: rgba(255,255,255,0.65);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-logout:hover { background: rgba(255,255,255,0.15); color: #fff; }

        /* Main content offset for fixed sidebar */
        .main-wrapper { margin-left: 240px; min-height: 100vh; }

        .main-content { padding: 2rem 2.5rem; }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8ecf0;
            padding: 1rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: #1a1a2e;
        }

        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .role-badge.admin     { background: rgba(192,57,43,0.1); color: #c0392b; }
        .role-badge.counselor { background: rgba(26,107,74,0.1); color: #1a6b4a; }
        .role-badge.student   { background: rgba(26,60,110,0.1); color: #1a3c6e; }

        /* Cards */
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
        .stat-card { border-left: 3px solid; }

        /* Flash alerts */
        .flash-success {
            background: #f0faf4;
            border: 1px solid #a8d5b5;
            border-radius: 10px;
            color: #1a6b4a;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .flash-error {
            background: #fef5f5;
            border: 1px solid #f5c6c6;
            border-radius: 10px;
            color: #c0392b;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>

{{-- ── Sidebar ── --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <span class="brand-name">Counseling System</span>
        <span class="brand-role">{{ ucfirst(auth()->user()->role) }} Portal</span>
    </div>

    <nav>
        @if(auth()->user()->isAdmin())
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="/admin/students" class="{{ request()->is('admin/students*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Students
            </a>
            <a href="/admin/sessions" class="{{ request()->is('admin/sessions*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Sessions
            </a>
            <a href="/admin/reports" class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Reports
            </a>

        @elseif(auth()->user()->isCounselor())
            <a href="/counselor/dashboard" class="{{ request()->is('counselor/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="/counselor/sessions" class="{{ request()->is('counselor/sessions*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> My Sessions
            </a>

        @elseif(auth()->user()->isStudent())
            <a href="/student/dashboard" class="{{ request()->is('student/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="/student/sessions" class="{{ request()->is('student/sessions*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> My Sessions
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
            <div class="user-name">{{ auth()->user()->name }}</div>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i> Sign Out
            </button>
        </form>
    </div>
</div>

{{-- ── Main Wrapper ── --}}
<div class="main-wrapper">
    <div class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <span class="role-badge {{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
    </div>

    <div class="main-content">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flash-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
