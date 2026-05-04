<style>
    body { background: var(--ink, #0b0d10); color: var(--text, #eeeae0); font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }
    .attempt-container {
        max-width: 650px;
        margin: 40px auto;
        background: var(--ink2, #131720);
        border-radius: 18px;
        box-shadow: 0 8px 32px #0008;
        padding: 36px 32px 32px 32px;
    }
    .attempt-title {
        display: flex; align-items: center; gap: 12px;
        font-size: 2.1rem; font-weight: 700; margin-bottom: 8px;
    }
    .attempt-desc { color: var(--muted, #8a8d9c); font-size: 1.1rem; margin-bottom: 28px; }
    .question-card {
        background: var(--ink3, #1c2130);
        border-radius: 14px;
        margin-bottom: 28px;
        padding: 24px 22px 18px 22px;
        box-shadow: 0 2px 12px #0002;
        border: 1px solid var(--line, rgba(255,255,255,.07));
    }
    .question-header {
        display: flex; align-items: flex-start; gap: 12px;
        margin-bottom: 12px;
    }
    .question-num {
        background: var(--gold-dim, #c9a84c18);
        color: var(--gold, #c9a84c);
        font-weight: 700;
        border-radius: 7px;
        padding: 4px 13px;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .question-body { font-size: 1.13rem; font-weight: 500; }
    .options-list { margin-top: 10px; }
    .option-label {
        display: flex; align-items: center; gap: 10px;
        background: var(--ink4, #252a3a);
        border-radius: 7px;
        padding: 10px 14px;
        margin-bottom: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background .15s;
        border: 1.5px solid transparent;
    }
    .option-label:hover { background: var(--ink3, #1c2130); border-color: var(--gold, #c9a84c30); }
    .option-label input[type="radio"], .option-label input[type="checkbox"] {
        accent-color: var(--gold, #c9a84c);
        width: 18px; height: 18px;
    }
    .input-answer {
        width: 100%;
        padding: 10px 14px;
        border-radius: 7px;
        border: 1.5px solid var(--line, rgba(255,255,255,.08));
        background: var(--ink4, #252a3a);
        color: var(--text, #eeeae0);
        font-size: 1rem;
        margin-top: 8px;
        margin-bottom: 8px;
    }
    .submit-btn {
        display: flex; align-items: center; gap: 8px;
        background: var(--gold, #c9a84c);
        color: var(--ink, #0b0d10);
        font-size: 1.1rem;
        font-weight: 600;
        border: none;
        border-radius: 9px;
        padding: 13px 28px;
        margin: 0 auto;
        margin-top: 18px;
        cursor: pointer;
        box-shadow: 0 2px 8px #0002;
        transition: background .18s, transform .13s;
    }
    .submit-btn:hover { background: var(--gold2, #e8c96a); transform: translateY(-2px) scale(1.04); }
</style>

<div class="attempt-container">
    <div class="attempt-title">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        {{ $quiz->title }}
    </div>
    <div class="attempt-desc">Answer all questions below and submit when ready.</div>

    <form method="POST" action="{{ route('quizzes.submit', $quiz->id) }}">
        @csrf

        @foreach($quiz->questions as $question)
            <div class="question-card">
                <div class="question-header">
                    <div class="question-num">Q{{ $loop->iteration }}</div>
                    <div class="question-body">{!! nl2br(e($question->body)) !!}</div>
                </div>
                <div class="options-list">
                @if(in_array($question->type, ['binary', 'single_choice']))
                    @foreach($question->options as $option)
                        <label class="option-label">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                            {{ $option->text }}
                        </label>
                    @endforeach
                @elseif($question->type == 'multiple_choice')
                    @foreach($question->options as $option)
                        <label class="option-label">
                            <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->id }}">
                            {{ $option->text }}
                        </label>
                    @endforeach
                @elseif($question->type == 'number')
                    <label>Enter number:
                        <input type="number" name="answers[{{ $question->id }}]" class="input-answer">
                    </label>
                @elseif($question->type == 'text')
                    <label>Enter answer:
                        <input type="text" name="answers[{{ $question->id }}]" class="input-answer">
                    </label>
                @endif
                </div>
            </div>
        @endforeach

        <button type="submit" class="submit-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0b0d10" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Submit Quiz
        </button>
    </form>
</div>
