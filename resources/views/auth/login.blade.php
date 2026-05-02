<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counseling System — Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f0f0f;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
        }

        .portal-wrapper {
            position: relative; z-index: 1;
            text-align: center;
            padding: 2rem;
            max-width: 960px;
            width: 100%;
        }

        .logo-area { margin-bottom: 3rem; animation: fadeDown 0.8s ease both; }

        .logo-icon {
            width: 68px; height: 68px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 30px; color: white; margin-bottom: 1.25rem;
            box-shadow: 0 8px 32px rgba(192,57,43,0.4);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: #fff; line-height: 1.1; margin-bottom: 0.5rem;
        }

        .subtitle {
            color: rgba(255,255,255,0.4);
            font-size: 0.9rem; letter-spacing: 0.08em; text-transform: uppercase;
        }

        .cards-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem; margin-top: 1rem;
        }

        /* Card is purely visual — not a link itself */
        .portal-card {
            position: relative;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 2.5rem 1.75rem;
            transition: transform 0.3s ease, border-color 0.3s ease, background 0.3s ease;
            overflow: hidden;
            animation: fadeUp 0.7s ease both;
        }

        .portal-card:nth-child(1) { animation-delay: 0.15s; }
        .portal-card:nth-child(2) { animation-delay: 0.25s; }
        .portal-card:nth-child(3) { animation-delay: 0.35s; }

        /* Glow overlay on hover */
        .portal-card::after {
            content: ''; position: absolute; inset: 0;
            opacity: 0; transition: opacity 0.3s ease; border-radius: 20px;
            pointer-events: none;
        }
        .portal-card.admin::after    { background: radial-gradient(circle at 50% 0%, rgba(192,57,43,0.2), transparent 70%); }
        .portal-card.counselor::after { background: radial-gradient(circle at 50% 0%, rgba(26,107,74,0.2), transparent 70%); }
        .portal-card.student::after  { background: radial-gradient(circle at 50% 0%, rgba(26,60,110,0.2), transparent 70%); }

        .portal-card:hover { transform: translateY(-8px); background: rgba(255,255,255,0.07); }
        .portal-card:hover::after { opacity: 1; }
        .portal-card.admin:hover    { border-color: rgba(192,57,43,0.5); }
        .portal-card.counselor:hover { border-color: rgba(26,107,74,0.5); }
        .portal-card.student:hover  { border-color: rgba(26,60,110,0.5); }

        .card-icon {
            width: 58px; height: 58px; border-radius: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 1.25rem;
        }
        .admin    .card-icon { background: rgba(192,57,43,0.15); color: #e74c3c; }
        .counselor .card-icon { background: rgba(26,107,74,0.15); color: #2ecc71; }
        .student  .card-icon { background: rgba(26,60,110,0.15); color: #5dade2; }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; color: #fff; margin-bottom: 0.5rem;
        }

        .card-desc {
            color: rgba(255,255,255,0.4);
            font-size: 0.85rem; line-height: 1.65; margin-bottom: 1.75rem;
        }

        .card-actions {
            display: flex; flex-direction: column; gap: 0.6rem;
            position: relative; z-index: 2;
        }

        .card-btn {
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
            font-size: 0.85rem; font-weight: 500;
            padding: 0.6rem 1.25rem; border-radius: 50px;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            font-family: 'DM Sans', sans-serif;
        }

        .card-btn.primary { background: rgba(255,255,255,0.12); color: #fff; border: none; }
        .card-btn.secondary {
            background: transparent; color: rgba(255,255,255,0.45);
            border: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem;
        }

        .admin    .card-btn.primary:hover { background: rgba(192,57,43,0.45); color: #fff; }
        .counselor .card-btn.primary:hover { background: rgba(26,107,74,0.45); color: #fff; }
        .student  .card-btn.primary:hover { background: rgba(26,60,110,0.45); color: #fff; }
        .card-btn.secondary:hover { color: #fff; border-color: rgba(255,255,255,0.3); }

        .footer-text {
            margin-top: 3rem; color: rgba(255,255,255,0.2); font-size: 0.8rem;
            animation: fadeUp 0.7s 0.5s ease both;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) { .cards-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="portal-wrapper">
    <div class="logo-area">
        <div class="logo-icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <h1>Student Counseling<br>System</h1>
        <p class="subtitle">Select your portal to continue</p>
    </div>

    <div class="cards-row">

        <div class="portal-card admin">
            <div class="card-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div class="card-title">Admin</div>
            <div class="card-desc">Manage students, counselors, sessions, and generate reports.</div>
            <div class="card-actions">
                <a href="/login/admin" class="card-btn primary">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </a>
                <a href="/register/admin" class="card-btn secondary">
                    <i class="bi bi-person-plus"></i> Create Account
                </a>
            </div>
        </div>

        <div class="portal-card counselor">
            <div class="card-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div class="card-title">Counselor</div>
            <div class="card-desc">View assigned sessions, conduct counseling, and write session notes.</div>
            <div class="card-actions">
                <a href="/login/counselor" class="card-btn primary">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </a>
                <a href="/register/counselor" class="card-btn secondary">
                    <i class="bi bi-person-plus"></i> Create Account
                </a>
            </div>
        </div>

        <div class="portal-card student">
            <div class="card-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div class="card-title">Student</div>
            <div class="card-desc">View your scheduled sessions and track your counseling progress.</div>
            <div class="card-actions">
                <a href="/login/student" class="card-btn primary">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </a>
                <a href="/register/student" class="card-btn secondary">
                    <i class="bi bi-person-plus"></i> Create Account
                </a>
            </div>
        </div>

    </div>

    <p class="footer-text">School Counseling Management System &copy; {{ date('Y') }}</p>
</div>
</body>
</html>