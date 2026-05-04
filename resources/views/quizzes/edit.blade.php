@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --gold:        #c9a84c;
        --gold-light:  #e2c97e;
        --gold-dim:    rgba(201,168,76,0.15);
        --gold-border: rgba(201,168,76,0.3);
        --bg:          #0e0f13;
        --surface:     #14151b;
        --surface-2:   #1b1d26;
        --surface-3:   #22253a;
        --border:      rgba(255,255,255,0.07);
        --text:        #edeef5;
        --text-muted:  #7c7f96;
        --text-dim:    #4e516a;
        --green:       #4ade80;
        --red:         #f87171;
        --radius-sm:   8px;
        --radius:      14px;
        --radius-lg:   20px;
        --shadow:      0 8px 40px rgba(0,0,0,0.5);
        --shadow-gold: 0 0 30px rgba(201,168,76,0.12);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    /* ── PAGE WRAPPER ── */
    .eq-page {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 48px 20px 80px;
        position: relative;
        overflow-x: hidden;
    }

    /* Radial glow behind the card */
    .eq-page::before {
        content: '';
        position: fixed;
        top: -20%;
        left: 50%;
        transform: translateX(-50%);
        width: 900px;
        height: 600px;
        background: radial-gradient(ellipse at center, rgba(201,168,76,0.08) 0%, transparent 65%);
        pointer-events: none;
        z-index: 0;
    }

    .eq-wrap {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 660px;
        animation: fadeUp .55s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── BREADCRUMB ── */
    .eq-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 32px;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--text-dim);
    }
    .eq-breadcrumb a {
        color: var(--text-dim);
        text-decoration: none;
        transition: color .2s;
    }
    .eq-breadcrumb a:hover { color: var(--gold); }
    .eq-breadcrumb svg { flex-shrink: 0; }
    .eq-breadcrumb span { color: var(--gold); }

    /* ── HEADER ── */
    .eq-header {
        margin-bottom: 36px;
    }
    .eq-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px 4px 8px;
        border: 1px solid var(--gold-border);
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--gold);
        background: var(--gold-dim);
        margin-bottom: 14px;
    }
    .eq-badge svg { opacity: .8; }
    .eq-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(28px, 5vw, 40px);
        font-weight: 700;
        color: var(--text);
        line-height: 1.15;
        margin-bottom: 8px;
    }
    .eq-title em {
        font-style: italic;
        color: var(--gold-light);
    }
    .eq-sub {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* ── ERROR ALERT ── */
    .eq-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px 18px;
        border: 1px solid rgba(248,113,113,0.3);
        background: rgba(248,113,113,0.07);
        border-radius: var(--radius);
        margin-bottom: 28px;
        color: #fca5a5;
        font-size: 13.5px;
        line-height: 1.6;
        animation: fadeUp .4s ease both;
    }
    .eq-alert svg { flex-shrink: 0; margin-top: 2px; }

    /* ── CARD ── */
    .eq-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow), var(--shadow-gold);
        overflow: hidden;
    }

    /* ── CARD HEADER ── */
    .eq-card-head {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 24px 28px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-2);
    }
    .eq-card-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        background: var(--gold-dim);
        border: 1px solid var(--gold-border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .eq-card-title {
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: var(--text);
    }
    .eq-card-subtitle {
        font-size: 12.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* Step indicator */
    .eq-steps {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .eq-step {
        width: 26px;
        height: 4px;
        border-radius: 100px;
        background: var(--surface-3);
    }
    .eq-step.active {
        background: var(--gold);
        box-shadow: 0 0 8px rgba(201,168,76,0.5);
    }

    /* ── FORM BODY ── */
    .eq-body {
        padding: 28px 28px 0;
        display: flex;
        flex-direction: column;
        gap: 26px;
    }

    /* ── FIELD ── */
    .eq-field {}
    .eq-field-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .eq-label {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .02em;
        color: var(--text);
    }
    .eq-required {
        color: var(--gold);
        margin-left: 3px;
    }
    .eq-char {
        font-size: 11.5px;
        color: var(--text-dim);
        font-variant-numeric: tabular-nums;
        transition: color .2s;
    }
    .eq-char.warn { color: var(--gold); }

    /* Input */
    .eq-input, .eq-textarea {
        width: 100%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s, background .2s;
        outline: none;
    }
    .eq-input {
        padding: 12px 16px;
        height: 48px;
    }
    .eq-textarea {
        padding: 14px 16px;
        min-height: 110px;
        resize: vertical;
        line-height: 1.6;
    }
    .eq-input::placeholder,
    .eq-textarea::placeholder { color: var(--text-dim); }

    .eq-input:focus,
    .eq-textarea:focus {
        border-color: var(--gold-border);
        background: var(--surface-3);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
    }
    .eq-input.err,
    .eq-textarea.err {
        border-color: rgba(248,113,113,0.5);
    }
    .eq-input.err:focus,
    .eq-textarea.err:focus {
        box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
    }

    /* Field error */
    .eq-field-err {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 7px;
        font-size: 12px;
        color: var(--red);
    }

    /* ── DIVIDER ── */
    .eq-divider {
        height: 1px;
        background: var(--border);
        margin: 0 -28px;
    }

    /* ── STATUS ── */
    .eq-status-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .eq-status-radio { display: none; }
    .eq-status-label {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        cursor: pointer;
        background: var(--surface-2);
        transition: border-color .2s, background .2s, box-shadow .2s;
        user-select: none;
    }
    .eq-status-label:hover {
        border-color: rgba(255,255,255,0.13);
        background: var(--surface-3);
    }
    .eq-status-radio:checked + .eq-status-label {
        border-color: var(--gold-border);
        background: var(--gold-dim);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.08);
    }
    .eq-status-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .eq-status-icon.green { background: rgba(74,222,128,0.1); }
    .eq-status-icon.gray  { background: rgba(255,255,255,0.05); }

    .eq-status-name {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text);
    }
    .eq-status-desc {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* Active indicator dot */
    .eq-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-left: auto;
        background: var(--border);
        flex-shrink: 0;
        transition: background .2s, box-shadow .2s;
    }
    .eq-status-radio:checked + .eq-status-label .eq-status-dot {
        background: var(--gold);
        box-shadow: 0 0 6px rgba(201,168,76,0.6);
    }

    /* ── FOOTER ── */
    .eq-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding: 24px 28px;
        margin-top: 28px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
    }

    .eq-btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0 18px;
        height: 42px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: transparent;
        color: var(--text-muted);
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: border-color .2s, color .2s, background .2s;
    }
    .eq-btn-ghost:hover {
        border-color: rgba(255,255,255,0.15);
        color: var(--text);
        background: var(--surface-3);
    }

    .eq-btn-gold {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0 22px;
        height: 42px;
        border: none;
        border-radius: var(--radius-sm);
        background: linear-gradient(135deg, var(--gold) 0%, #a8782a 100%);
        color: #1a1200;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: .02em;
        transition: opacity .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 4px 18px rgba(201,168,76,0.3);
        position: relative;
        overflow: hidden;
    }
    .eq-btn-gold::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.18) 0%, transparent 60%);
        pointer-events: none;
    }
    .eq-btn-gold:hover {
        opacity: .9;
        transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(201,168,76,0.4);
    }
    .eq-btn-gold:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(201,168,76,0.3);
    }

    /* ── INFO ROW (bottom hint) ── */
    .eq-info {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-top: 20px;
        font-size: 12px;
        color: var(--text-dim);
        justify-content: center;
    }
    .eq-info svg { flex-shrink: 0; }

    /* ── RESPONSIVE ── */
    @media (max-width: 520px) {
        .eq-page { padding: 28px 14px 60px; }
        .eq-body  { padding: 22px 20px 0; }
        .eq-card-head { padding: 20px; gap: 12px; }
        .eq-footer { padding: 18px 20px; flex-wrap: wrap; }
        .eq-btn-ghost, .eq-btn-gold { flex: 1; justify-content: center; }
        .eq-status-grid { grid-template-columns: 1fr; }
        .eq-steps { display: none; }
    }
</style>

<div class="eq-page">
<div class="eq-wrap">

    {{-- ── BREADCRUMB ── --}}
    <nav class="eq-breadcrumb" aria-label="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
        <a href="{{ route('quizzes.index') }}">Quizzes</a>
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
        <span>Edit</span>
    </nav>

    {{-- ── HEADER ── --}}
    <header class="eq-header">
        <div class="eq-badge">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Editing quiz
        </div>
        <h1 class="eq-title">Edit your <em>quiz</em></h1>
        <p class="eq-sub">Update the details below. You can manage questions after saving.</p>
    </header>

    {{-- ── ERROR ALERT ── --}}
    @if ($errors->any())
    <div class="eq-alert" role="alert">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
        <div>
            <strong>Please fix the following:</strong><br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── FORM CARD ── --}}
    <form method="POST" action="{{ route('quizzes.update', $quiz->id) }}">
    @csrf
    @method('PUT')

    <div class="eq-card">

        {{-- Card Header --}}
        <div class="eq-card-head">
            <div class="eq-card-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><rect x="4" y="7" width="16" height="15" rx="2"/><path d="M9 2v4M15 2v4M9 12h6M9 16h4"/></svg>
            </div>
            <div>
                <div class="eq-card-title">Quiz details</div>
                <div class="eq-card-subtitle">Basic information about your quiz</div>
            </div>
            <div class="eq-steps">
                <div class="eq-step active"></div>
                <div class="eq-step"></div>
                <div class="eq-step"></div>
            </div>
        </div>

        {{-- Form Body --}}
        <div class="eq-body">

            {{-- Title --}}
            <div class="eq-field">
                <div class="eq-field-row">
                    <label class="eq-label" for="title">
                        Title <span class="eq-required">*</span>
                    </label>
                    <span class="eq-char" id="title-count">{{ strlen(old('title', $quiz->title)) }} / 100</span>
                </div>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="eq-input {{ $errors->has('title') ? 'err' : '' }}"
                    placeholder="e.g. JavaScript Fundamentals"
                    value="{{ old('title', $quiz->title) }}"
                    maxlength="100"
                    oninput="
                        const c = document.getElementById('title-count');
                        c.textContent = this.value.length + ' / 100';
                        c.classList.toggle('warn', this.value.length > 80);
                    "
                    required
                    autocomplete="off"
                >
                @error('title')
                    <div class="eq-field-err">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="eq-divider"></div>

            {{-- Description --}}
            <div class="eq-field">
                <label class="eq-label" for="description" style="display:block;margin-bottom:8px;">
                    Description <span style="color:var(--text-dim);font-weight:400;font-size:12px;">(optional)</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    class="eq-textarea {{ $errors->has('description') ? 'err' : '' }}"
                    placeholder="Give participants a brief overview of what this quiz covers…"
                    maxlength="500"
                >{{ old('description', $quiz->description) }}</textarea>
                @error('description')
                    <div class="eq-field-err">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="eq-divider"></div>

            {{-- Status --}}
            <div class="eq-field" style="padding-bottom: 4px;">
                <label class="eq-label" style="display:block;margin-bottom:12px;">Visibility status</label>
                <div class="eq-status-grid">

                    {{-- Active --}}
                    <input type="radio" class="eq-status-radio" id="status-active" name="status" value="active"
                        {{ old('status', $quiz->status) == 'active' ? 'checked' : '' }}>
                    <label class="eq-status-label" for="status-active">
                        <span class="eq-status-icon green">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>
                        </span>
                        <span>
                            <div class="eq-status-name">Active</div>
                            <div class="eq-status-desc">Visible to users</div>
                        </span>
                        <span class="eq-status-dot"></span>
                    </label>

                    {{-- Draft --}}
                    <input type="radio" class="eq-status-radio" id="status-draft" name="status" value="draft"
                        {{ old('status', $quiz->status) == 'draft' ? 'checked' : '' }}>
                    <label class="eq-status-label" for="status-draft">
                        <span class="eq-status-icon gray">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8a8d9c" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/></svg>
                        </span>
                        <span>
                            <div class="eq-status-name">Draft</div>
                            <div class="eq-status-desc">Hidden from users</div>
                        </span>
                        <span class="eq-status-dot"></span>
                    </label>

                </div>
            </div>

        </div>{{-- /eq-body --}}

        {{-- Card Footer --}}
        <div class="eq-footer">
            <a href="{{ route('quizzes.index') }}" class="eq-btn-ghost">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                Cancel
            </a>
            <button type="submit" class="eq-btn-gold">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save changes
            </button>
        </div>

    </div>{{-- /eq-card --}}
    </form>

    {{-- Bottom hint --}}
    <p class="eq-info">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
        Questions can be added or edited from the quiz detail page after saving.
    </p>

</div>
</div>

@endsection