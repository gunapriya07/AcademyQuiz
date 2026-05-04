@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Mono:wght@400;500&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .qa-root {
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
        --gold-subtle: rgba(212,168,71,0.12);
        --gold-border: rgba(212,168,71,0.25);
        --mono: 'DM Mono', monospace;
        --sans: 'DM Sans', sans-serif;
        min-height: 100vh;
        background: var(--bg);
        color: var(--text);
        font-family: var(--sans);
        padding: 0 0 80px;
    }

    /* ─── Hero Strip ─── */
    .qa-hero {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 48px 24px 40px;
    }

    .qa-hero-inner {
        max-width: 720px;
        margin: 0 auto;
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .qa-icon {
        width: 48px;
        height: 48px;
        background: var(--gold-subtle);
        border: 1px solid var(--gold-border);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .qa-hero-text { flex: 1; }

    .qa-label {
        font-family: var(--mono);
        font-size: 11px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
        display: block;
    }

    .qa-title {
        font-size: clamp(1.5rem, 3.5vw, 2rem);
        font-weight: 600;
        color: var(--text);
        letter-spacing: -0.025em;
        line-height: 1.2;
        margin-bottom: 8px;
    }

    .qa-subtitle {
        font-size: 0.925rem;
        color: var(--text-muted);
        font-weight: 300;
    }

    /* ─── Progress Bar ─── */
    .qa-progress-wrap {
        max-width: 720px;
        margin: 0 auto;
        padding: 20px 24px 0;
    }

    .qa-progress-bar {
        height: 2px;
        background: var(--surface-3);
        border-radius: 2px;
        overflow: hidden;
    }

    .qa-progress-fill {
        height: 100%;
        background: var(--gold);
        border-radius: 2px;
        width: 0%;
        transition: width 0.4s ease;
    }

    .qa-progress-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
    }

    .qa-progress-label {
        font-family: var(--mono);
        font-size: 11px;
        color: var(--text-muted);
        letter-spacing: 0.06em;
    }

    /* ─── Form Body ─── */
    .qa-form-wrap {
        max-width: 720px;
        margin: 0 auto;
        padding: 32px 24px 0;
    }

    .qa-form { display: flex; flex-direction: column; gap: 16px; }

    /* ─── Question Card ─── */
    .qa-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .qa-card:hover { border-color: var(--border-hover); }

    .qa-card-top {
        padding: 22px 24px 18px;
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .qa-qnum {
        font-family: var(--mono);
        font-size: 11px;
        color: var(--gold);
        background: var(--gold-subtle);
        border: 1px solid var(--gold-border);
        border-radius: 6px;
        padding: 4px 10px;
        letter-spacing: 0.08em;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .qa-question-text {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text);
        line-height: 1.65;
        flex: 1;
    }

    .qa-card-body {
        padding: 0 24px 22px;
        border-top: 1px solid var(--border);
        padding-top: 16px;
    }

    /* ─── Options ─── */
    .qa-options { display: flex; flex-direction: column; gap: 8px; }

    .qa-option {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 13px 16px;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
        position: relative;
    }

    .qa-option:hover {
        background: var(--surface-3);
        border-color: var(--border-hover);
    }

    .qa-option input[type="radio"],
    .qa-option input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border: 1.5px solid rgba(255,255,255,0.2);
        border-radius: 50%;
        background: transparent;
        cursor: pointer;
        flex-shrink: 0;
        transition: border-color 0.15s, background 0.15s;
        position: relative;
    }

    .qa-option input[type="checkbox"] { border-radius: 5px; }

    .qa-option input[type="radio"]:checked,
    .qa-option input[type="checkbox"]:checked {
        background: var(--gold);
        border-color: var(--gold);
    }

    .qa-option input[type="radio"]:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background: var(--bg);
        border-radius: 50%;
    }

    .qa-option input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        width: 5px;
        height: 9px;
        border-right: 2px solid var(--bg);
        border-bottom: 2px solid var(--bg);
        margin-top: -2px;
    }

    .qa-option-text {
        font-size: 0.925rem;
        color: var(--text-dim);
        line-height: 1.5;
        flex: 1;
    }

    /* Selected state */
    .qa-option:has(input:checked) {
        background: var(--gold-subtle);
        border-color: var(--gold-border);
    }

    .qa-option:has(input:checked) .qa-option-text { color: var(--text); }

    /* ─── Text / Number Inputs ─── */
    .qa-input-label {
        font-family: var(--mono);
        font-size: 11px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
        display: block;
    }

    .qa-input {
        width: 100%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text);
        font-family: var(--sans);
        font-size: 0.95rem;
        padding: 12px 16px;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        -webkit-appearance: none;
    }

    .qa-input:focus {
        border-color: var(--gold-border);
        box-shadow: 0 0 0 3px rgba(212,168,71,0.1);
    }

    .qa-input::placeholder { color: var(--text-muted); }

    /* ─── Submit ─── */
    .qa-submit-wrap {
        max-width: 720px;
        margin: 32px auto 0;
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .qa-submit-note {
        font-size: 13px;
        color: var(--text-muted);
    }

    .qa-submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--gold);
        color: #0a0b0e;
        font-family: var(--sans);
        font-size: 0.95rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 14px 28px;
        cursor: pointer;
        letter-spacing: -0.01em;
        transition: opacity 0.15s, transform 0.12s;
        position: relative;
        overflow: hidden;
    }

    .qa-submit-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0);
        transition: background 0.15s;
    }

    .qa-submit-btn:hover::before { background: rgba(255,255,255,0.12); }
    .qa-submit-btn:active { transform: scale(0.98); }

    .qa-submit-btn svg { flex-shrink: 0; }

    /* ─── Responsive ─── */
    @media (max-width: 560px) {
        .qa-hero { padding: 36px 16px 32px; }
        .qa-form-wrap, .qa-progress-wrap, .qa-submit-wrap { padding-left: 16px; padding-right: 16px; }
        .qa-card-top { padding: 18px 16px 14px; }
        .qa-card-body { padding: 14px 16px 18px; }
    }
</style>

<div class="qa-root">

    {{-- Hero --}}
    <div class="qa-hero">
        <div class="qa-hero-inner">
            <div class="qa-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d4a847" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
            </div>
            <div class="qa-hero-text">
                <span class="qa-label">Assessment</span>
                <h1 class="qa-title">{{ $quiz->title }}</h1>
                <p class="qa-subtitle">Complete all questions below, then submit when ready.</p>
            </div>
        </div>
    </div>

    {{-- Progress --}}
    @php $questionCount = $quiz->questions->count(); @endphp
    <div class="qa-progress-wrap">
        <div class="qa-progress-bar">
            <div class="qa-progress-fill" id="qa-progress-fill"></div>
        </div>
        <div class="qa-progress-meta">
            <span class="qa-progress-label">Progress</span>
            <span class="qa-progress-label" id="qa-progress-text">0 / {{ $questionCount }} answered</span>
        </div>
    </div>

    {{-- Form --}}
    <div class="qa-form-wrap">
        <form method="POST" action="{{ route('quizzes.submit', $quiz->id) }}" class="qa-form" id="qa-form">
            @csrf

            @foreach($quiz->questions as $question)
                <div class="qa-card">
                    <div class="qa-card-top">
                        <div class="qa-qnum">Q{{ $loop->iteration }}</div>
                        <p class="qa-question-text">{!! nl2br(e($question->body)) !!}</p>
                    </div>
                    <div class="qa-card-body">

                        @if(in_array($question->type, ['binary', 'single_choice']))
                            <div class="qa-options">
                                @foreach($question->options as $option)
                                    <label class="qa-option">
                                        <input type="radio"
                                               name="answers[{{ $question->id }}]"
                                               value="{{ $option->id }}"
                                               data-trackable>
                                        <span class="qa-option-text">{{ $option->text }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($question->type == 'multiple_choice')
                            <div class="qa-options">
                                @foreach($question->options as $option)
                                    <label class="qa-option">
                                        <input type="checkbox"
                                               name="answers[{{ $question->id }}][]"
                                               value="{{ $option->id }}"
                                               data-trackable>
                                        <span class="qa-option-text">{{ $option->text }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($question->type == 'number')
                            <label class="qa-input-label">Enter a number</label>
                            <input type="number"
                                   name="answers[{{ $question->id }}]"
                                   class="qa-input"
                                   placeholder="0"
                                   data-trackable>

                        @elseif($question->type == 'text')
                            <label class="qa-input-label">Your answer</label>
                            <input type="text"
                                   name="answers[{{ $question->id }}]"
                                   class="qa-input"
                                   placeholder="Type your answer…"
                                   data-trackable>
                        @endif

                    </div>
                </div>
            @endforeach
        </form>
    </div>

    {{-- Submit --}}
    <div class="qa-submit-wrap">
        <span class="qa-submit-note">All answers are final once submitted.</span>
        <button type="submit" form="qa-form" class="qa-submit-btn">
            Submit quiz
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

</div>

<script>
(function () {
    var total = {{ $questionCount }};
    var fill  = document.getElementById('qa-progress-fill');
    var label = document.getElementById('qa-progress-text');
    var answered = new Set();

    function update() {
        var pct = total > 0 ? (answered.size / total) * 100 : 0;
        fill.style.width  = pct + '%';
        label.textContent = answered.size + ' / ' + total + ' answered';
    }

    document.querySelectorAll('[data-trackable]').forEach(function (el) {
        var name = el.name.replace(/\[\]$/, '');
        el.addEventListener('change', function () {
            if (el.type === 'checkbox') {
                var anyChecked = document.querySelectorAll('[name="' + el.name + '"]:checked').length > 0;
                if (anyChecked) answered.add(name); else answered.delete(name);
            } else if (el.type === 'radio') {
                answered.add(name);
            } else {
                if (el.value.trim()) answered.add(name); else answered.delete(name);
            }
            update();
        });
    });

    update();
})();
</script>
@endsection