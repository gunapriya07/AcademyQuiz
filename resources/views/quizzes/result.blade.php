@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Mono:wght@400;500&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .qr-root {
        --bg: #0a0b0e;
        --surface: #111318;
        --surface-2: #171b24;
        --surface-3: #1e2330;
        --border: rgba(255,255,255,0.07);
        --border-hover: rgba(255,255,255,0.14);
        --text: #f0ece4;
        --text-muted: #6b7280;
        --text-dim: #9ca3af;
        --gold: #d4a847;
        --gold-subtle: rgba(212,168,71,0.10);
        --gold-border: rgba(212,168,71,0.22);
        --green: #4ade80;
        --green-subtle: rgba(74,222,128,0.10);
        --green-border: rgba(74,222,128,0.22);
        --red: #f87171;
        --red-subtle: rgba(248,113,113,0.10);
        --red-border: rgba(248,113,113,0.22);
        --mono: 'DM Mono', monospace;
        --sans: 'DM Sans', sans-serif;
        min-height: 100vh;
        background: var(--bg);
        color: var(--text);
        font-family: var(--sans);
        padding: 0 0 80px;
    }

    /* ─── Hero ─── */
    .qr-hero {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 52px 24px 44px;
        text-align: center;
    }

    .qr-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--mono);
        font-size: 11px;
        letter-spacing: 0.13em;
        text-transform: uppercase;
        color: var(--green);
        background: var(--green-subtle);
        border: 1px solid var(--green-border);
        padding: 5px 14px;
        border-radius: 100px;
        margin-bottom: 20px;
    }

    .qr-badge-dot {
        width: 6px;
        height: 6px;
        background: var(--green);
        border-radius: 50%;
    }

    .qr-title {
        font-size: clamp(1.5rem, 3.5vw, 2rem);
        font-weight: 600;
        letter-spacing: -0.025em;
        margin-bottom: 8px;
        color: var(--text);
        line-height: 1.2;
    }

    .qr-sub {
        font-size: 0.925rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    /* ─── Body ─── */
    .qr-body {
        max-width: 720px;
        margin: 0 auto;
        padding: 36px 24px 0;
    }

    /* ─── Score Card ─── */
    .qr-score-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 32px;
        display: flex;
        align-items: center;
        gap: 32px;
        margin-bottom: 36px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }

    .qr-score-card::after {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(212,168,71,0.05) 0%, transparent 65%);
        pointer-events: none;
    }

    /* Ring */
    .qr-ring {
        position: relative;
        width: 112px;
        height: 112px;
        flex-shrink: 0;
    }

    .qr-ring-svg {
        transform: rotate(-90deg);
        width: 112px;
        height: 112px;
    }

    .qr-ring-track {
        fill: none;
        stroke: rgba(255,255,255,0.06);
        stroke-width: 7;
    }

    .qr-ring-arc {
        fill: none;
        stroke: var(--gold);
        stroke-width: 7;
        stroke-linecap: round;
        stroke-dasharray: 301;
        transition: stroke-dashoffset 1.2s cubic-bezier(.4,0,.2,1);
    }

    .qr-ring-inner {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1px;
    }

    .qr-pct {
        font-size: 1.55rem;
        font-weight: 600;
        color: var(--text);
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .qr-pct-label {
        font-family: var(--mono);
        font-size: 10px;
        color: var(--text-muted);
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* Meta */
    .qr-score-meta { flex: 1; min-width: 180px; }

    .qr-score-heading {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 400;
        margin-bottom: 6px;
        letter-spacing: 0.02em;
    }

    .qr-score-number {
        font-size: 2.4rem;
        font-weight: 600;
        color: var(--text);
        letter-spacing: -0.04em;
        line-height: 1;
        margin-bottom: 20px;
    }

    .qr-score-number em {
        font-size: 1rem;
        font-style: normal;
        font-weight: 400;
        color: var(--text-muted);
        letter-spacing: 0;
    }

    .qr-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .qr-stat {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
    }

    .qr-stat-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .qr-stat-label { color: var(--text-muted); }
    .qr-stat-val { color: var(--text); font-weight: 500; }

    /* ─── Section Header ─── */
    .qr-section-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }

    .qr-section-line {
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .qr-section-label {
        font-family: var(--mono);
        font-size: 11px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--text-muted);
        flex-shrink: 0;
    }

    /* ─── Question Cards ─── */
    .qr-questions { display: flex; flex-direction: column; gap: 12px; }

    .qr-qcard {
        background: var(--surface);
        border: 1px solid var(--border);
        border-left-width: 3px;
        border-radius: 14px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .qr-qcard:hover { border-color: var(--border-hover); border-left-color: inherit; }
    .qr-qcard.is-correct { border-left-color: var(--green); }
    .qr-qcard.is-wrong   { border-left-color: var(--red); }

    .qr-qcard-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 20px 22px 16px;
    }

    .qr-qcard-left {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .qr-qnum {
        font-family: var(--mono);
        font-size: 11px;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        flex-shrink: 0;
        padding-top: 2px;
    }

    .qr-qtext {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text);
        line-height: 1.65;
    }

    .qr-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 500;
        flex-shrink: 0;
        white-space: nowrap;
    }

    .qr-status svg { width: 12px; height: 12px; flex-shrink: 0; }

    .qr-status.correct {
        background: var(--green-subtle);
        color: var(--green);
        border: 1px solid var(--green-border);
    }

    .qr-status.wrong {
        background: var(--red-subtle);
        color: var(--red);
        border: 1px solid var(--red-border);
    }

    .qr-qcard-body {
        padding: 14px 22px 20px;
        border-top: 1px solid var(--border);
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: baseline;
        gap: 8px 16px;
    }

    .qr-answer-block {}

    .qr-answer-key {
        font-family: var(--mono);
        font-size: 10px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .qr-answer-val {
        font-size: 0.9rem;
        color: var(--text-dim);
        line-height: 1.5;
    }

    .qr-answer-val.empty { font-style: italic; color: var(--text-muted); }

    .qr-marks-pill {
        font-family: var(--mono);
        font-size: 12px;
        font-weight: 500;
        padding: 4px 12px;
        border-radius: 7px;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border);
        color: var(--text-dim);
        white-space: nowrap;
        align-self: end;
    }

    /* ─── Footer ─── */
    .qr-footer {
        text-align: center;
        margin-top: 48px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }

    .qr-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: transparent;
        color: var(--text-dim);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-family: var(--sans);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: border-color 0.15s, color 0.15s, background 0.15s;
    }

    .qr-back-btn:hover {
        border-color: var(--border-hover);
        color: var(--text);
        background: var(--surface);
    }

    /* ─── Responsive ─── */
    @media (max-width: 540px) {
        .qr-hero { padding: 40px 16px 36px; }
        .qr-body { padding: 28px 16px 0; }
        .qr-score-card { flex-direction: column; align-items: flex-start; padding: 24px; gap: 24px; }
        .qr-qcard-top { flex-wrap: wrap; }
        .qr-qcard-body { grid-template-columns: 1fr; }
        .qr-marks-pill { justify-self: start; }
    }
</style>

<div class="qr-root">

    {{-- Hero --}}
    <div class="qr-hero">
        <div class="qr-badge">
            <span class="qr-badge-dot"></span>
            Quiz complete
        </div>
        <h1 class="qr-title">{{ $attempt->quiz->title }}</h1>
        <p class="qr-sub">Here's a full breakdown of your performance</p>
    </div>

    <div class="qr-body">

        {{-- Score card --}}
        @php
            $totalQ    = $attempt->answers->count();
            $correct   = $attempt->answers->where('is_correct', true)->count();
            $wrong     = $totalQ - $correct;
            $maxMarks  = $attempt->answers->sum(fn($a) => optional($a->question)->marks ?? 0);
            $score     = $attempt->total_score;
            $pct       = $maxMarks > 0 ? round(($score / $maxMarks) * 100) : 0;
            $radius    = 48;
            $circ      = round(2 * M_PI * $radius, 1);
            $offset    = round($circ - ($circ * min($score / max($maxMarks, 1), 1)), 2);
        @endphp

        <div class="qr-score-card">
            <div class="qr-ring">
                <svg class="qr-ring-svg" viewBox="0 0 112 112" xmlns="http://www.w3.org/2000/svg">
                    <circle class="qr-ring-track" cx="56" cy="56" r="{{ $radius }}"/>
                    <circle class="qr-ring-arc"   cx="56" cy="56" r="{{ $radius }}"
                        style="stroke-dasharray: {{ $circ }}; stroke-dashoffset: {{ $offset }};"/>
                </svg>
                <div class="qr-ring-inner">
                    <span class="qr-pct">{{ $pct }}%</span>
                    <span class="qr-pct-label">Score</span>
                </div>
            </div>

            <div class="qr-score-meta">
                <p class="qr-score-heading">Total marks awarded</p>
                <div class="qr-score-number">
                    {{ $score }}
                    @if($maxMarks > 0)
                        <em>/ {{ $maxMarks }}</em>
                    @endif
                </div>
                <div class="qr-stats">
                    <div class="qr-stat">
                        <span class="qr-stat-dot" style="background: var(--green);"></span>
                        <span class="qr-stat-label">Correct</span>
                        <span class="qr-stat-val">{{ $correct }}</span>
                    </div>
                    <div class="qr-stat">
                        <span class="qr-stat-dot" style="background: var(--red);"></span>
                        <span class="qr-stat-label">Incorrect</span>
                        <span class="qr-stat-val">{{ $wrong }}</span>
                    </div>
                    <div class="qr-stat">
                        <span class="qr-stat-label">Questions</span>
                        <span class="qr-stat-val">{{ $totalQ }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Question review --}}
        <div class="qr-section-head">
            <div class="qr-section-line"></div>
            <span class="qr-section-label">Question review</span>
            <div class="qr-section-line"></div>
        </div>

        <div class="qr-questions">
            @foreach($attempt->answers as $index => $answer)
                @php
                    $given   = $answer->given_answer;
                    $decoded = json_decode($given, true);
                    if (is_array($decoded)) { $given = implode(', ', $decoded); }
                    $isCorrect = $answer->is_correct;
                @endphp

                <div class="qr-qcard {{ $isCorrect ? 'is-correct' : 'is-wrong' }}">
                    <div class="qr-qcard-top">
                        <div class="qr-qcard-left">
                            <span class="qr-qnum">Q{{ $index + 1 }}</span>
                            <p class="qr-qtext">{{ $answer->question->text ?? $answer->question->body }}</p>
                        </div>
                        <span class="qr-status {{ $isCorrect ? 'correct' : 'wrong' }}">
                            @if($isCorrect)
                                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 6l3 3 5-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Correct
                            @else
                                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 3l6 6M9 3l-6 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                </svg>
                                Incorrect
                            @endif
                        </span>
                    </div>

                    <div class="qr-qcard-body">
                        <div class="qr-answer-block">
                            <p class="qr-answer-key">Your answer</p>
                            <p class="qr-answer-val {{ $given ? '' : 'empty' }}">{{ $given ?: 'No answer provided' }}</p>
                        </div>
                        <div class="qr-marks-pill">{{ $answer->marks_awarded }} pts</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="qr-footer">
            <a href="{{ route('quizzes.index') }}" class="qr-back-btn">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 11L5 7l4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Quizzes
            </a>
        </div>

        <script>
            // Redirect to quizzes page after 5 seconds
            setTimeout(function() {
                window.location.href = '{{ route('quizzes.index') }}';
            }, 5000);
        </script>

    </div>
</div>
@endsection