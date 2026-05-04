@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .quiz-result-wrapper {
        min-height: 100vh;
        background: #0d0f14;
        padding: 3rem 1rem;
        font-family: 'Sora', sans-serif;
    }

    .quiz-result-container {
        max-width: 780px;
        margin: 0 auto;
    }

    /* Header */
    .result-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .result-badge {
        display: inline-block;
        font-family: 'DM Mono', monospace;
        font-size: 11px;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #6ee7b7;
        background: rgba(110, 231, 183, 0.08);
        border: 1px solid rgba(110, 231, 183, 0.2);
        padding: 6px 16px;
        border-radius: 100px;
        margin-bottom: 1.25rem;
    }

    .result-title {
        font-size: clamp(1.6rem, 4vw, 2.4rem);
        font-weight: 700;
        color: #f5f4f0;
        margin: 0 0 0.5rem;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .result-subtitle {
        font-size: 0.95rem;
        color: #6b7280;
        margin: 0;
    }

    /* Score Card */
    .score-card {
        background: linear-gradient(135deg, #1a1f2e 0%, #151920 100%);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }

    .score-card::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(110,231,183,0.07) 0%, transparent 70%);
        pointer-events: none;
    }

    .score-ring {
        position: relative;
        width: 110px;
        height: 110px;
        flex-shrink: 0;
    }

    .score-ring svg {
        transform: rotate(-90deg);
        width: 110px;
        height: 110px;
    }

    .score-ring-bg {
        fill: none;
        stroke: rgba(255,255,255,0.06);
        stroke-width: 8;
    }

    .score-ring-fill {
        fill: none;
        stroke: #6ee7b7;
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: 283;
        stroke-dashoffset: {{ 283 - (283 * min($attempt->total_score / ($attempt->answers->sum('question.marks') ?: 1), 1)) }};
        transition: stroke-dashoffset 1s ease;
    }

    .score-ring-label {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .score-number {
        font-size: 1.6rem;
        font-weight: 700;
        color: #f5f4f0;
    }

    .score-label {
        font-size: 10px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-top: 2px;
        font-family: 'DM Mono', monospace;
    }

    .score-meta {
        flex: 1;
    }

    .score-meta h3 {
        font-size: 1rem;
        font-weight: 500;
        color: #9ca3af;
        margin: 0 0 0.4rem;
    }

    .score-total {
        font-size: 2.2rem;
        font-weight: 700;
        color: #f5f4f0;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .score-total span {
        font-size: 1rem;
        color: #6b7280;
        font-weight: 400;
    }

    .score-stats {
        display: flex;
        gap: 1.5rem;
        margin-top: 1.25rem;
        flex-wrap: wrap;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .stat-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .stat-dot.correct { background: #6ee7b7; }
    .stat-dot.wrong { background: #f87171; }

    .stat-label { color: #9ca3af; }
    .stat-value { color: #f5f4f0; font-weight: 500; }

    /* Divider */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .section-divider-line {
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.07);
    }

    .section-divider-text {
        font-family: 'DM Mono', monospace;
        font-size: 11px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #4b5563;
    }

    /* Question Cards */
    .question-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .question-card {
        background: #131720;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .question-card:hover {
        border-color: rgba(255,255,255,0.12);
    }

    .question-card.correct-card {
        border-left: 3px solid #6ee7b7;
    }

    .question-card.wrong-card {
        border-left: 3px solid #f87171;
    }

    .question-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem 1.5rem 1rem;
    }

    .question-index {
        font-family: 'DM Mono', monospace;
        font-size: 11px;
        color: #4b5563;
        letter-spacing: 0.08em;
        flex-shrink: 0;
        padding-top: 2px;
    }

    .question-text {
        font-size: 0.95rem;
        font-weight: 500;
        color: #e5e7eb;
        line-height: 1.6;
        flex: 1;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 500;
        flex-shrink: 0;
    }

    .status-badge.correct {
        background: rgba(110, 231, 183, 0.1);
        color: #6ee7b7;
        border: 1px solid rgba(110, 231, 183, 0.2);
    }

    .status-badge.wrong {
        background: rgba(248, 113, 113, 0.1);
        color: #f87171;
        border: 1px solid rgba(248, 113, 113, 0.2);
    }

    .status-badge svg {
        width: 12px;
        height: 12px;
        flex-shrink: 0;
    }

    .question-card-body {
        padding: 0 1.5rem 1.25rem;
        border-top: 1px solid rgba(255,255,255,0.04);
        margin-top: 0;
    }

    .answer-row {
        display: flex;
        align-items: baseline;
        gap: 0.75rem;
        padding-top: 1rem;
    }

    .answer-row-label {
        font-family: 'DM Mono', monospace;
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #4b5563;
        flex-shrink: 0;
        min-width: 90px;
    }

    .answer-row-value {
        font-size: 0.9rem;
        color: #9ca3af;
        line-height: 1.5;
    }

    .marks-chip {
        display: inline-block;
        font-family: 'DM Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 6px;
        background: rgba(255,255,255,0.05);
        color: #d1d5db;
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* Footer */
    .result-footer {
        text-align: center;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    .result-footer a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: rgba(110, 231, 183, 0.1);
        color: #6ee7b7;
        border: 1px solid rgba(110, 231, 183, 0.25);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .result-footer a:hover {
        background: rgba(110, 231, 183, 0.16);
        border-color: rgba(110, 231, 183, 0.4);
    }

    @media (max-width: 540px) {
        .score-card { flex-direction: column; align-items: flex-start; padding: 1.75rem; }
        .question-card-header { flex-wrap: wrap; }
    }
</style>

<div class="quiz-result-wrapper">
    <div class="quiz-result-container">

        {{-- Header --}}
        <div class="result-header">
            <div class="result-badge">Quiz Complete</div>
            <h1 class="result-title">{{ $attempt->quiz->title }}</h1>
            <p class="result-subtitle">Here's a breakdown of your performance</p>
        </div>

        {{-- Score Card --}}
        @php
            $totalQuestions = $attempt->answers->count();
            $correctCount   = $attempt->answers->where('is_correct', true)->count();
            $wrongCount     = $totalQuestions - $correctCount;
            $maxMarks       = $attempt->answers->sum(fn($a) => optional($a->question)->marks ?? 0);
            $percentage     = $maxMarks > 0 ? round(($attempt->total_score / $maxMarks) * 100) : 0;
            $ringOffset     = 283 - (283 * min($attempt->total_score / max($maxMarks, 1), 1));
        @endphp

        <div class="score-card">
            <div class="score-ring">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle class="score-ring-bg" cx="50" cy="50" r="45"/>
                    <circle class="score-ring-fill" cx="50" cy="50" r="45"
                        style="stroke-dashoffset: {{ $ringOffset }}"/>
                </svg>
                <div class="score-ring-label">
                    <span class="score-number">{{ $percentage }}%</span>
                    <span class="score-label">Score</span>
                </div>
            </div>

            <div class="score-meta">
                <h3>Total marks awarded</h3>
                <div class="score-total">
                    {{ $attempt->total_score }}
                    @if($maxMarks > 0)
                        <span>/ {{ $maxMarks }}</span>
                    @endif
                </div>

                <div class="score-stats">
                    <div class="stat-pill">
                        <span class="stat-dot correct"></span>
                        <span class="stat-label">Correct&nbsp;</span>
                        <span class="stat-value">{{ $correctCount }}</span>
                    </div>
                    <div class="stat-pill">
                        <span class="stat-dot wrong"></span>
                        <span class="stat-label">Incorrect&nbsp;</span>
                        <span class="stat-value">{{ $wrongCount }}</span>
                    </div>
                    <div class="stat-pill">
                        <span class="stat-label">Questions&nbsp;</span>
                        <span class="stat-value">{{ $totalQuestions }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Question List --}}
        <div class="section-divider">
            <div class="section-divider-line"></div>
            <span class="section-divider-text">Question Review</span>
            <div class="section-divider-line"></div>
        </div>

        <div class="question-list">
            @foreach($attempt->answers as $index => $answer)
                @php
                    $given = $answer->given_answer;
                    $decoded = json_decode($given, true);
                    if (is_array($decoded)) {
                        $given = implode(', ', $decoded);
                    }
                @endphp

                <div class="question-card {{ $answer->is_correct ? 'correct-card' : 'wrong-card' }}">
                    <div class="question-card-header">
                        <span class="question-index">Q{{ $index + 1 }}</span>
                        <p class="question-text">{{ $answer->question->text ?? $answer->question->body }}</p>
                        @if($answer->is_correct)
                            <span class="status-badge correct">
                                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 6L5 9L10 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Correct
                            </span>
                        @else
                            <span class="status-badge wrong">
                                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 3L9 9M9 3L3 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                </svg>
                                Incorrect
                            </span>
                        @endif
                    </div>

                    <div class="question-card-body">
                        <div class="answer-row">
                            <span class="answer-row-label">Your answer</span>
                            <span class="answer-row-value">{{ $given ?: '—' }}</span>
                        </div>
                        <div class="answer-row">
                            <span class="answer-row-label">Marks</span>
                            <span class="marks-chip">{{ $answer->marks_awarded }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="result-footer">
            <a href="{{ url()->previous() }}">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Quizzes
            </a>
        </div>

    </div>
</div>
@endsection