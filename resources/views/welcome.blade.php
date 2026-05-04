    <meta name="csrf-token" content="{{ csrf_token() }}">
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AcademyQuiz — Assessments Built for Depth</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:     #0b0d10;
            --ink2:    #131720;
            --ink3:    #1c2130;
            --surface: #212840;
            --gold:    #c9a84c;
            --gold2:   #e8c96a;
            --gold-dim:#c9a84c28;
            --text:    #eeeae0;
            --muted:   #8a8d9c;
            --line:    rgba(201,168,76,.18);
            --r:       10px;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--ink);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ── Noise texture overlay ───────────────────────────── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* ── Page wrapper ────────────────────────────────────── */
        .page { position: relative; z-index: 1; }

        /* ── NAV ─────────────────────────────────────────────── */
        nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 48px;
            border-bottom: 1px solid var(--line);
            background: rgba(11,13,16,.7);
            backdrop-filter: blur(14px);
            position: sticky; top: 0; z-index: 100;
        }

        .nav-brand {
            display: flex; align-items: center; gap: 10px;
        }

        .brand-mark {
            width: 34px; height: 34px;
            background: var(--gold);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }

        .brand-mark svg { width: 18px; height: 18px; }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 19px;
            letter-spacing: -.3px;
            color: var(--text);
        }

        .brand-name span { color: var(--gold); }

        .nav-links {
            display: flex; align-items: center; gap: 8px;
        }

        .nav-link {
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 400;
            color: var(--muted);
            text-decoration: none;
            border: 1px solid transparent;
            transition: all .2s;
        }

        .nav-link:hover { color: var(--text); border-color: var(--line); }

        .nav-link.primary {
            background: var(--gold);
            color: var(--ink);
            font-weight: 500;
            border-color: var(--gold);
        }

        .nav-link.primary:hover { background: var(--gold2); }

        /* ── HERO ────────────────────────────────────────────── */
        .hero {
            min-height: 88vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center;
            padding: 80px 24px 60px;
            position: relative;
            overflow: hidden;
        }

        /* radial glow behind hero text */
        .hero::after {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,.08) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
            pointer-events: none;
        }

        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 11px; letter-spacing: 2.5px; text-transform: uppercase;
            color: var(--gold);
            border: 1px solid var(--gold-dim);
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 32px;
            background: var(--gold-dim);
            animation: fadeUp .6s ease both;
        }

        .eyebrow-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold);
            animation: pulse 2s ease infinite;
        }

        @keyframes pulse {
            0%,100% { opacity: 1; } 50% { opacity: .4; }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: clamp(42px, 7vw, 88px);
            line-height: 1.07;
            letter-spacing: -.03em;
            max-width: 820px;
            animation: fadeUp .6s .1s ease both;
        }

        .hero-title em {
            font-style: italic;
            color: var(--gold);
        }

        .hero-sub {
            margin-top: 24px;
            font-size: 17px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.75;
            animation: fadeUp .6s .2s ease both;
        }

        .hero-cta {
            display: flex; align-items: center; gap: 12px;
            margin-top: 44px;
            animation: fadeUp .6s .3s ease both;
        }

        .btn-gold {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px;
            background: var(--gold);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 500;
            border-radius: var(--r);
            text-decoration: none;
            border: none; cursor: pointer;
            transition: all .2s;
        }

        .btn-gold:hover { background: var(--gold2); transform: translateY(-1px); }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px;
            background: transparent;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 400;
            border-radius: var(--r);
            text-decoration: none;
            border: 1px solid var(--line);
            cursor: pointer;
            transition: all .2s;
        }

        .btn-outline:hover { border-color: rgba(201,168,76,.4); color: var(--gold); }

        /* ── STATS STRIP ─────────────────────────────────────── */
        .stats-strip {
            display: flex; align-items: center; justify-content: center;
            gap: 0;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: 28px 48px;
            animation: fadeUp .6s .4s ease both;
        }

        .stat-item {
            flex: 1; text-align: center;
            padding: 0 32px;
            border-right: 1px solid var(--line);
        }

        .stat-item:last-child { border-right: none; }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 32px; font-weight: 700;
            color: var(--gold);
            line-height: 1;
        }

        .stat-label {
            font-size: 12px; color: var(--muted);
            margin-top: 4px; letter-spacing: .5px;
        }

        /* ── SECTION SHARED ──────────────────────────────────── */
        section { padding: 100px 48px; max-width: 1160px; margin: 0 auto; }

        .section-label {
            font-size: 11px; letter-spacing: 2.5px; text-transform: uppercase;
            color: var(--gold); margin-bottom: 14px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 700; line-height: 1.15;
            letter-spacing: -.02em;
        }

        .section-title em { font-style: italic; color: var(--gold); }

        .section-sub {
            margin-top: 14px;
            font-size: 15px; color: var(--muted);
            max-width: 480px; line-height: 1.7;
        }

        /* ── FEATURES GRID ───────────────────────────────────── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 60px;
        }

        .feat-card {
            background: var(--ink2);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 28px 26px 30px;
            position: relative;
            overflow: hidden;
            transition: border-color .25s, transform .25s;
        }

        .feat-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), transparent);
            opacity: 0;
            transition: opacity .3s;
        }

        .feat-card:hover { border-color: rgba(201,168,76,.35); transform: translateY(-3px); }
        .feat-card:hover::before { opacity: 1; }

        .feat-icon {
            width: 44px; height: 44px;
            background: var(--gold-dim);
            border-radius: 10px;
            border: 1px solid var(--line);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
            font-size: 20px;
        }

        .feat-title {
            font-size: 15px; font-weight: 500;
            margin-bottom: 8px;
        }

        .feat-desc {
            font-size: 13px; color: var(--muted);
            line-height: 1.65;
        }

        /* ── QUESTION TYPES ──────────────────────────────────── */
        .types-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .types-list {
            display: flex; flex-direction: column; gap: 10px;
            margin-top: 40px;
        }

        .type-row {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 18px;
            background: var(--ink2);
            border: 1px solid var(--line);
            border-radius: var(--r);
            transition: all .2s;
            cursor: default;
        }

        .type-row:hover { border-color: rgba(201,168,76,.3); background: var(--ink3); }

        .type-badge {
            width: 36px; height: 36px; flex-shrink: 0;
            background: var(--gold-dim);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
        }

        .type-info { flex: 1; }
        .type-name { font-size: 13px; font-weight: 500; }
        .type-example { font-size: 11px; color: var(--muted); margin-top: 2px; }

        .type-check {
            width: 18px; height: 18px; flex-shrink: 0;
            background: rgba(201,168,76,.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── QUIZ PREVIEW CARD ───────────────────────────────── */
        .quiz-preview {
            background: var(--ink2);
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
        }

        .preview-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--line);
            display: flex; align-items: center; justify-content: space-between;
        }

        .preview-dots { display: flex; gap: 6px; }
        .preview-dot { width: 10px; height: 10px; border-radius: 50%; }

        .preview-body { padding: 24px 20px; }

        .preview-label {
            font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
            color: var(--gold); margin-bottom: 12px;
        }

        .preview-question {
            font-size: 14px; line-height: 1.6;
            margin-bottom: 20px;
        }

        .preview-options { display: flex; flex-direction: column; gap: 8px; }

        .preview-opt {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--line);
            font-size: 12px;
            background: var(--ink3);
            transition: all .2s;
            cursor: default;
        }

        .preview-opt.selected {
            border-color: var(--gold);
            background: var(--gold-dim);
        }

        .preview-opt.correct {
            border-color: #4ade80;
            background: rgba(74,222,128,.08);
        }

        .opt-radio {
            width: 14px; height: 14px; border-radius: 50%;
            border: 1.5px solid var(--muted);
            flex-shrink: 0;
        }

        .preview-opt.selected .opt-radio {
            background: var(--gold);
            border-color: var(--gold);
        }

        .preview-opt.correct .opt-radio {
            background: #4ade80;
            border-color: #4ade80;
        }

        .preview-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--line);
            display: flex; align-items: center; justify-content: space-between;
        }

        .score-pill {
            font-size: 11px; font-weight: 500;
            padding: 4px 12px;
            background: rgba(74,222,128,.12);
            color: #4ade80;
            border-radius: 20px;
            border: 1px solid rgba(74,222,128,.2);
        }

        /* ── HOW IT WORKS ────────────────────────────────────── */
        .how-grid {
            display: grid; grid-template-columns: repeat(4,1fr);
            gap: 20px; margin-top: 60px;
            position: relative;
        }

        .how-grid::before {
            content: '';
            position: absolute;
            top: 28px; left: 60px; right: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--line), var(--line), transparent);
        }

        .how-step { text-align: center; padding: 0 16px; }

        .how-num {
            width: 56px; height: 56px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--ink2);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 700;
            color: var(--gold);
            position: relative; z-index: 1;
        }

        .how-title { font-size: 14px; font-weight: 500; margin-bottom: 8px; }
        .how-desc { font-size: 12px; color: var(--muted); line-height: 1.65; }

        /* ── CTA BANNER ──────────────────────────────────────── */
        .cta-banner {
            margin: 0 48px 80px;
            background: var(--ink2);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 64px 60px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 40px;
            position: relative;
            overflow: hidden;
        }

        .cta-banner::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,.08) 0%, transparent 70%);
        }

        .cta-text { max-width: 480px; }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px; font-weight: 700;
            line-height: 1.2; letter-spacing: -.02em;
        }

        .cta-title em { font-style: italic; color: var(--gold); }

        .cta-sub {
            margin-top: 12px;
            font-size: 14px; color: var(--muted); line-height: 1.7;
        }

        .cta-actions {
            display: flex; flex-direction: column; gap: 10px;
            flex-shrink: 0;
        }

        /* ── FOOTER ──────────────────────────────────────────── */
        footer {
            border-top: 1px solid var(--line);
            padding: 28px 48px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 15px; font-weight: 700;
            color: var(--muted);
        }

        .footer-brand span { color: var(--gold); }

        .footer-copy {
            font-size: 12px; color: var(--muted);
        }

        /* ── ANIMATIONS ──────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-up {
            opacity: 0;
            animation: fadeUp .6s ease forwards;
        }

        /* ── RESPONSIVE ──────────────────────────────────────── */
        @media (max-width: 900px) {
            nav { padding: 18px 24px; }
            section { padding: 60px 24px; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .types-section { grid-template-columns: 1fr; }
            .how-grid { grid-template-columns: 1fr 1fr; }
            .how-grid::before { display: none; }
            .cta-banner { margin: 0 24px 60px; flex-direction: column; text-align: center; padding: 40px 32px; }
            .cta-actions { width: 100%; }
            .stats-strip { flex-wrap: wrap; gap: 24px; }
            .stat-item { border-right: none; }
            footer { flex-direction: column; gap: 12px; text-align: center; }
        }

        @media (max-width: 600px) {
            .nav-links .nav-link:not(.primary) { display: none; }
            .features-grid { grid-template-columns: 1fr; }
            .hero-cta { flex-direction: column; width: 100%; }
            .btn-gold, .btn-outline { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ── NAVBAR ── --}}
    <nav>
        <div class="nav-brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0b0d10" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                </svg>
            </div>
            <span class="brand-name">Academy<span>Quiz</span></span>
        </div>

        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                @else
                    <a href="{{ route('login') }}" class="nav-link">Sign in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link primary">Get started free</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    {{-- ── HERO ── --}}
    <div class="hero">
        <div class="hero-eyebrow">
            <span class="eyebrow-dot"></span>
            The flexible quiz platform
        </div>
        <h1 class="hero-title">
            Build quizzes that<br><em>actually test</em> understanding
        </h1>
        <p class="hero-sub">
            AcademyQuiz supports five question types, rich media, and smart evaluation logic — all from one elegant interface.
        </p>
        <div class="hero-cta">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-gold">
                    Create your first quiz
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
            <a href="#how-it-works" class="btn-outline">See how it works</a>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="stats-strip animate-up" style="animation-delay:.5s">
        <div class="stat-item">
            <div class="stat-num">5</div>
            <div class="stat-label">Question types</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">∞</div>
            <div class="stat-label">Questions per quiz</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">100%</div>
            <div class="stat-label">Extensible architecture</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">Live</div>
            <div class="stat-label">Score evaluation</div>
        </div>
    </div>

    {{-- ── FEATURES ── --}}
    <section>
        <div class="section-label">Why AcademyQuiz</div>
        <h2 class="section-title">Everything you need to<br><em>assess & evaluate</em></h2>
        <p class="section-sub">Designed from the ground up for clarity, extensibility, and honest scoring.</p>

        <div class="features-grid">
            <div class="feat-card">
                <div class="feat-icon">
                    <!-- Lightning bolt -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                </div>
                <div class="feat-title">Instant evaluation</div>
                <div class="feat-desc">Scores are calculated the moment a quiz is submitted — no waiting, no manual grading. Every question type has its own smart scoring logic.</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon">
                    <!-- Image icon -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <div class="feat-title">Rich media support</div>
                <div class="feat-desc">Attach images or YouTube videos to any question. Options can carry text, images, or both — for visual learners and complex assessments.</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon">
                    <!-- Puzzle piece -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 13.255V7a2 2 0 0 0-2-2h-6.255A1.994 1.994 0 0 0 11 3a2 2 0 1 0-2 2c0 .35.06.687.17 1H5a2 2 0 0 0-2 2v6.255A1.994 1.994 0 0 0 3 13a2 2 0 1 0 2 2c.35 0 .687-.06 1-.17V19a2 2 0 0 0 2 2h6.255c-.11-.313-.17-.65-.17-1a2 2 0 1 0 2-2c.35 0 .687.06 1 .17V13a2 2 0 0 0 2-2z"/></svg>
                </div>
                <div class="feat-title">Extensible by design</div>
                <div class="feat-desc">Built on the Strategy pattern. Adding a new question type takes one new class — no changes to existing logic, no fragile if-else chains.</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon">
                    <!-- Pencil -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2a2.828 2.828 0 0 1 4 4L7 21l-4 1 1-4L18 2z"/></svg>
                </div>
                <div class="feat-title">Rich text editor</div>
                <div class="feat-desc">Write question bodies in HTML or rich text. Format code snippets, bold key terms, and structure complex questions with precision.</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon">
                    <!-- Bar chart -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                </div>
                <div class="feat-title">Detailed results</div>
                <div class="feat-desc">After submission, students see their score, correct answers, and exactly where they went wrong — question by question.</div>
            </div>
            <div class="feat-card">
                <div class="feat-icon">
                    <!-- Target icon -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                </div>
                <div class="feat-title">Custom marks per question</div>
                <div class="feat-desc">Assign different mark values to different questions. Weight harder questions more heavily and build a fair total score automatically.</div>
            </div>
        </div>
    </section>

    {{-- ── QUESTION TYPES ── --}}
    <section style="padding-top: 0">
        <div class="types-section">
            <div>
                <div class="section-label">Question types</div>
                <h2 class="section-title">Five types.<br><em>One system.</em></h2>
                <p class="section-sub">Every type is handled by its own evaluation class — consistent, testable, and easy to extend.</p>

                <div class="types-list">
                    <div class="type-row">
                        <div class="type-badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/></svg></div>
                        <div class="type-info">
                            <div class="type-name">Binary</div>
                            <div class="type-example">Yes / No · True / False</div>
                        </div>
                        <div class="type-check">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4l3 3 5-6" stroke="#c9a84c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="type-row">
                        <div class="type-badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="6"/></svg></div>
                        <div class="type-info">
                            <div class="type-name">Single choice</div>
                            <div class="type-example">One correct option from many</div>
                        </div>
                        <div class="type-check">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4l3 3 5-6" stroke="#c9a84c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="type-row">
                        <div class="type-badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M7 13l3 3 7-7"/></svg></div>
                        <div class="type-info">
                            <div class="type-name">Multiple choice</div>
                            <div class="type-example">Select all correct options</div>
                        </div>
                        <div class="type-check">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4l3 3 5-6" stroke="#c9a84c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="type-row">
                        <div class="type-badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><text x="4" y="17" font-size="14" font-family="monospace">#</text></svg></div>
                        <div class="type-info">
                            <div class="type-name">Number input</div>
                            <div class="type-example">Exact numeric answer</div>
                        </div>
                        <div class="type-check">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4l3 3 5-6" stroke="#c9a84c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="type-row">
                        <div class="type-badge"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><text x="2" y="15" font-size="13" font-family="monospace">Aa</text></svg></div>
                        <div class="type-info">
                            <div class="type-name">Text input</div>
                            <div class="type-example">Open-ended short answer</div>
                        </div>
                        <div class="type-check">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4l3 3 5-6" stroke="#c9a84c" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quiz preview card --}}
            <div class="quiz-preview">
                <div class="preview-header">
                    <div class="preview-dots">
                        <div class="preview-dot" style="background:#ff5f57"></div>
                        <div class="preview-dot" style="background:#febc2e"></div>
                        <div class="preview-dot" style="background:#28c840"></div>
                    </div>
                    <span style="font-size:11px;color:var(--muted)">Laravel Basics · Q4</span>
                </div>
                <div class="preview-body">
                    <div class="preview-label">Single choice · 2 marks</div>
                    <div class="preview-question">Which Artisan command creates a new Eloquent model?</div>
                    <div class="preview-options">
                        <div class="preview-opt">
                            <div class="opt-radio"></div>
                            <span>php artisan create:model User</span>
                        </div>
                        <div class="preview-opt selected">
                            <div class="opt-radio"></div>
                            <span style="color:var(--gold)">php artisan make:model User</span>
                        </div>
                        <div class="preview-opt">
                            <div class="opt-radio"></div>
                            <span>php artisan generate:model User</span>
                        </div>
                        <div class="preview-opt correct">
                            <div class="opt-radio"></div>
                            <span style="color:#4ade80">php artisan make:model User ✓</span>
                        </div>
                    </div>
                </div>
                <div class="preview-footer">
                    <span style="font-size:12px;color:var(--muted)">3 of 8 answered</span>
                    <span class="score-pill">Score: 6 / 10</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── HOW IT WORKS ── --}}
    <section id="how-it-works" style="padding-top: 0">
        <div style="text-align:center">
            <div class="section-label">How it works</div>
            <h2 class="section-title" style="margin: 0 auto">From idea to <em>graded quiz</em></h2>
        </div>

        <div class="how-grid">
            <div class="how-step">
                <div class="how-num">1</div>
                <div class="how-title">Create a quiz</div>
                <div class="how-desc">Give it a title, description, and set your defaults. Takes under a minute.</div>
            </div>
            <div class="how-step">
                <div class="how-num">2</div>
                <div class="how-title">Add questions</div>
                <div class="how-desc">Pick from 5 question types, write in rich text, upload images or paste a YouTube link.</div>
            </div>
            <div class="how-step">
                <div class="how-num">3</div>
                <div class="how-title">Share & attempt</div>
                <div class="how-desc">Students open the quiz, answer all questions, and submit in one flow.</div>
            </div>
            <div class="how-step">
                <div class="how-num">4</div>
                <div class="how-title">See results</div>
                <div class="how-desc">Scores are calculated instantly. Every answer is reviewed with feedback shown.</div>
            </div>
        </div>
    </section>

    {{-- ── CTA BANNER ── --}}
    <div class="cta-banner">
        <div class="cta-text">
            <h2 class="cta-title">Ready to build your<br><em>first assessment?</em></h2>
            <p class="cta-sub">Get started in seconds. No credit card required. No complex setup.</p>
        </div>
        <div class="cta-actions">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-gold">
                    Create free account
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-outline">Sign in to existing account</a>
            @endif
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <footer>
        <div class="footer-brand">Academy<span>Quiz</span></div>
        <div class="footer-copy">Built with Laravel · {{ date('Y') }}</div>
    </footer>

        <!-- Floating Login/Signup Button -->
        <button id="auth-fab" onclick="document.getElementById('auth-modal').style.display='block'">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <span>Login / Signup</span>
        </button>

        <!-- Auth Modal (hidden by default, markup to be added next) -->
        <div id="auth-modal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.45);backdrop-filter:blur(2px);align-items:center;justify-content:center;">
            <div style="background:var(--ink2);padding:40px 32px 32px 32px;border-radius:18px;max-width:370px;width:90vw;box-shadow:0 8px 32px #0008;position:relative;">
                <button onclick="document.getElementById('auth-modal').style.display='none'" style="position:absolute;top:18px;right:18px;background:none;border:none;font-size:22px;color:var(--muted);cursor:pointer;">&times;</button>
                <div id="auth-modal-content">
                    <div style="display:flex;gap:10px;margin-bottom:28px;justify-content:center;">
                        <button id="tab-login" class="auth-tab active" onclick="showAuthTab('login')">Login</button>
                        <button id="tab-signup" class="auth-tab" onclick="showAuthTab('signup')">Sign Up</button>
                    </div>
                    <form id="login-form" method="POST" action="/login" style="display:block;">
                        <input type="hidden" name="_token" id="login-csrf">
                        <div style="margin-bottom:18px;">
                            <label for="login-email" style="font-size:13px;font-weight:500;">Email</label>
                            <input id="login-email" name="email" type="email" required style="width:100%;margin-top:6px;padding:11px 12px;border-radius:8px;border:1px solid var(--line);background:var(--ink3);color:var(--text);font-size:14px;">
                        </div>
                        <div style="margin-bottom:22px;">
                            <label for="login-password" style="font-size:13px;font-weight:500;">Password</label>
                            <input id="login-password" name="password" type="password" required style="width:100%;margin-top:6px;padding:11px 12px;border-radius:8px;border:1px solid var(--line);background:var(--ink3);color:var(--text);font-size:14px;">
                        </div>
                        <button type="submit" class="btn-gold" style="width:100%;justify-content:center;">Login</button>
                    </form>
                    <form id="signup-form" method="POST" action="/register" style="display:none;">
                        <input type="hidden" name="_token" id="signup-csrf">
                        <div style="margin-bottom:18px;">
                            <label for="signup-name" style="font-size:13px;font-weight:500;">Name</label>
                            <input id="signup-name" name="name" type="text" required style="width:100%;margin-top:6px;padding:11px 12px;border-radius:8px;border:1px solid var(--line);background:var(--ink3);color:var(--text);font-size:14px;">
                        </div>
                        <div style="margin-bottom:18px;">
                            <label for="signup-email" style="font-size:13px;font-weight:500;">Email</label>
                            <input id="signup-email" name="email" type="email" required style="width:100%;margin-top:6px;padding:11px 12px;border-radius:8px;border:1px solid var(--line);background:var(--ink3);color:var(--text);font-size:14px;">
                        </div>
                        <div style="margin-bottom:22px;">
                            <label for="signup-password" style="font-size:13px;font-weight:500;">Password</label>
                            <input id="signup-password" name="password" type="password" required style="width:100%;margin-top:6px;padding:11px 12px;border-radius:8px;border:1px solid var(--line);background:var(--ink3);color:var(--text);font-size:14px;">
                        </div>
                        <button type="submit" class="btn-gold" style="width:100%;justify-content:center;">Sign Up</button>
                    </form>
                </div>
                <style>
                    .auth-tab {
                        background: none;
                        border: none;
                        color: var(--muted);
                        font-size: 15px;
                        font-weight: 500;
                        padding: 8px 22px;
                        border-radius: 8px 8px 0 0;
                        cursor: pointer;
                        transition: color .2s, background .2s;
                    }
                    .auth-tab.active {
                        color: var(--gold);
                        background: var(--ink3);
                    }
                </style>
            </div>
        </div>

        <style>
            #auth-fab {
                position: fixed;
                bottom: 32px;
                right: 32px;
                z-index: 9999;
                background: var(--gold);
                color: var(--ink);
                border: none;
                border-radius: 50px;
                box-shadow: 0 4px 16px #0004;
                padding: 13px 22px 13px 16px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 15px;
                font-weight: 500;
                cursor: pointer;
                transition: background .2s, transform .2s;
            }
            #auth-fab:hover { background: var(--gold2); transform: translateY(-2px) scale(1.04); }
            @media (max-width: 600px) {
                #auth-fab { bottom: 18px; right: 18px; padding: 11px 16px 11px 12px; font-size: 13px; }
            }
        </style>

</div>

<script>
    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.feat-card, .type-row, .how-step').forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(18px)';
        el.style.transition = `opacity .5s ${i * 0.07}s ease, transform .5s ${i * 0.07}s ease`;
        observer.observe(el);
    });
</script>
<script>
// AJAX login/signup handling
function showError(msg) {
    let err = document.getElementById('auth-error');
    if (!err) {
        err = document.createElement('div');
        err.id = 'auth-error';
        err.style = 'color:#ff6b6b;background:#1c2130;padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;text-align:center;';
        document.getElementById('auth-modal-content').prepend(err);
    }
    err.innerText = msg;
}

function clearError() {
    let err = document.getElementById('auth-error');
    if (err) err.remove();
}


function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

document.getElementById('login-form').onsubmit = async function(e) {
    e.preventDefault();
    clearError();
    const form = e.target;
    const data = new FormData(form);
    const resp = await fetch('/login', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
        },
        body: data
    });
    if (resp.redirected) {
        window.location = resp.url;
        return;
    }
    const json = await resp.json().catch(() => ({}));
    if (json.errors) {
        showError(Object.values(json.errors).flat().join('\n'));
    } else if (json.message) {
        showError(json.message);
    } else {
        showError('Login failed.');
    }
};

document.getElementById('signup-form').onsubmit = async function(e) {
    e.preventDefault();
    clearError();
    const form = e.target;
    const data = new FormData(form);
    const resp = await fetch('/register', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
        },
        body: data
    });
    if (resp.redirected) {
        window.location = resp.url;
        return;
    }
    const json = await resp.json().catch(() => ({}));
    if (json.errors) {
        showError(Object.values(json.errors).flat().join('\n'));
    } else if (json.message) {
        showError(json.message);
    } else {
        showError('Signup failed.');
    }
};
</script>
</script>
<script>
    // Inject CSRF token into modal forms
    function setCsrfToken() {
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.getElementById('login-csrf').value = token;
        document.getElementById('signup-csrf').value = token;
    }
    setCsrfToken();
</script>
<script>
    function showAuthTab(tab) {
        document.getElementById('tab-login').classList.remove('active');
        document.getElementById('tab-signup').classList.remove('active');
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('signup-form').style.display = 'none';
        if(tab === 'login') {
            document.getElementById('tab-login').classList.add('active');
            document.getElementById('login-form').style.display = 'block';
        } else {
            document.getElementById('tab-signup').classList.add('active');
            document.getElementById('signup-form').style.display = 'block';
        }
    }
</script>
</body>
</body>
</html>