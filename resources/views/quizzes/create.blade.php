@extends('layouts.app')

@section('content')

<style>
    :root {
        --ink:      #0b0d10;
        --ink2:     #131720;
        --ink3:     #1c2130;
        --ink4:     #252a3a;
        --gold:     #c9a84c;
        --gold2:    #e8c96a;
        --gold-dim: #c9a84c18;
        --gold-bdr: #c9a84c30;
        --text:     #eeeae0;
        --muted:    #8a8d9c;
        --line:     rgba(201,168,76,.14);
        --green:    #4ade80;
        --red:      #f87171;
        --r:        12px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .form-page {
        min-height: 100vh;
        background: var(--ink);
        color: var(--text);
        font-family: 'DM Sans', 'Segoe UI', sans-serif;
        font-weight: 300;
        padding-bottom: 80px;
    }

    .form-page::before {
        content: '';
        position: fixed; inset: 0; z-index: 0; pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
    }

    .form-inner {
        position: relative; z-index: 1;
        max-width: 680px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ── HEADER ── */
    .form-header {
        padding: 52px 0 36px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 40px;
    }

    .breadcrumb {
        display: flex; align-items: center; gap: 7px;
        font-size: 12px; color: var(--muted);
        margin-bottom: 14px;
    }

    .breadcrumb a { color: var(--muted); text-decoration: none; }
    .breadcrumb a:hover { color: var(--gold); }
    .breadcrumb span { color: var(--text); }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(26px, 4vw, 36px);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -.025em;
    }

    .page-title em { font-style: italic; color: var(--gold); }
    .page-sub { margin-top: 8px; font-size: 14px; color: var(--muted); line-height: 1.6; }

    /* ── CARD ── */
    .form-card {
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 18px;
        overflow: hidden;
        animation: fadeUp .45s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-card-header {
        padding: 22px 28px;
        border-bottom: 1px solid var(--line);
        display: flex; align-items: center; gap: 12px;
    }

    .card-icon {
        width: 38px; height: 38px;
        background: var(--gold-dim);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
        border: 1px solid var(--gold-bdr);
    }

    .card-header-text h2 {
        font-family: 'Playfair Display', serif;
        font-size: 16px; font-weight: 700;
        letter-spacing: -.01em;
    }

    .card-header-text p {
        font-size: 12px; color: var(--muted); margin-top: 2px;
    }

    .form-body { padding: 28px; }

    /* ── FORM ELEMENTS ── */
    .field { margin-bottom: 22px; }
    .field:last-of-type { margin-bottom: 0; }

    .field-label {
        display: block;
        font-size: 11px; font-weight: 500;
        letter-spacing: .8px; text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .field-label .required { color: var(--gold); margin-left: 3px; }

    .field-hint {
        font-size: 11px; color: var(--muted);
        margin-top: 6px; line-height: 1.5;
    }

    .input, .textarea, .select {
        width: 100%;
        background: var(--ink3);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: var(--r);
        padding: 11px 16px;
        color: var(--text);
        font-family: inherit;
        font-size: 14px; font-weight: 300;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        -webkit-appearance: none;
    }

    .input::placeholder, .textarea::placeholder { color: var(--muted); }

    .input:focus, .textarea:focus, .select:focus {
        border-color: rgba(201,168,76,.45);
        box-shadow: 0 0 0 3px rgba(201,168,76,.07);
    }

    .textarea { resize: vertical; min-height: 110px; line-height: 1.6; }

    .select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a8d9c' stroke-width='2' stroke-linecap='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }

    /* validation states */
    .input.error, .textarea.error, .select.error {
        border-color: rgba(248,113,113,.5);
    }

    .field-error {
        font-size: 11px; color: var(--red);
        margin-top: 6px; display: flex; align-items: center; gap: 5px;
    }

    /* char counter */
    .field-row {
        display: flex; align-items: flex-end; justify-content: space-between;
        margin-bottom: 8px;
    }

    .char-count { font-size: 11px; color: var(--muted); }

    /* status options */
    .status-options {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 10px; margin-top: 2px;
    }

    .status-option { display: none; }

    .status-label {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 16px;
        background: var(--ink3);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: var(--r);
        cursor: pointer;
        transition: all .2s;
    }

    .status-option:checked + .status-label {
        border-color: var(--gold-bdr);
        background: var(--gold-dim);
    }

    .status-option[value="draft"]:checked + .status-label { border-color: rgba(96,165,250,.3); background: rgba(96,165,250,.07); }

    .status-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; flex-shrink: 0;
    }

    .status-option:checked + .status-label .status-icon { background: var(--gold-dim); }
    .status-option[value="draft"]:checked + .status-label .status-icon { background: rgba(96,165,250,.12); }
    .status-option:not(:checked) + .status-label .status-icon { background: var(--ink4); }

    .status-text { font-size: 13px; font-weight: 400; }
    .status-subtext { font-size: 11px; color: var(--muted); margin-top: 1px; }

    /* divider */
    .form-divider {
        height: 1px; background: var(--line);
        margin: 24px 0;
    }

    /* ── FORM FOOTER ── */
    .form-footer {
        padding: 20px 28px;
        border-top: 1px solid var(--line);
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px;
    }

    .btn-gold {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 24px;
        background: var(--gold);
        color: var(--ink);
        font-family: inherit; font-size: 13px; font-weight: 500;
        border-radius: 9px; border: none; cursor: pointer;
        transition: background .2s, transform .15s;
        text-decoration: none;
    }

    .btn-gold:hover { background: var(--gold2); transform: translateY(-1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 11px 20px;
        background: transparent; color: var(--muted);
        font-family: inherit; font-size: 13px; font-weight: 300;
        border-radius: 9px;
        border: 1px solid rgba(255,255,255,.08);
        cursor: pointer; text-decoration: none;
        transition: all .2s;
    }

    .btn-ghost:hover { border-color: rgba(255,255,255,.18); color: var(--text); }

    /* ── ALERTS ── */
    @if ($errors->any())
    .alert-error {
        display: flex; gap: 12px; align-items: flex-start;
        padding: 14px 18px;
        background: rgba(248,113,113,.08);
        border: 1px solid rgba(248,113,113,.2);
        border-radius: var(--r);
        margin-bottom: 24px;
        font-size: 13px; color: var(--red);
        line-height: 1.5;
        animation: fadeUp .3s ease both;
    }
    @endif

    @media (max-width: 600px) {
        .form-inner { padding: 0 16px; }
        .status-options { grid-template-columns: 1fr; }
        .form-footer { flex-direction: column-reverse; }
        .btn-gold, .btn-ghost { width: 100%; justify-content: center; }
    }
</style>

<div class="form-page">
<div class="form-inner">

    {{-- ── HEADER ── --}}
    <div class="form-header">
        <div class="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
            <a href="{{ route('quizzes.index') }}">Quizzes</a>
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
            <span>Create</span>
        </div>
        <h1 class="page-title">Create a <em>new quiz</em></h1>
        <p class="page-sub">Fill in the details below. You can add questions after saving.</p>
    </div>

    {{-- ── ERROR ALERT ── --}}
    @if ($errors->any())
    <div class="alert-error">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
        <div>
            <strong>Please fix the following:</strong><br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── FORM CARD ── --}}
    <form method="POST" action="{{ route('quizzes.store') }}">
    @csrf

    <div class="form-card">

        {{-- Card header --}}
        <div class="form-card-header">
            <div class="card-icon">
                <!-- Clipboard icon -->
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><rect x="4" y="7" width="16" height="15" rx="2"/><path d="M9 2v4"/><path d="M15 2v4"/></svg>
            </div>
            <div class="card-header-text">
                <h2>Quiz details</h2>
                <p>Basic information about your quiz</p>
            </div>
        </div>

        <div class="form-body">

            {{-- Title --}}
            <div class="field">
                <div class="field-row">
                    <label class="field-label" for="title">
                        Title <span class="required">*</span>
                    </label>
                    <span class="char-count" id="title-count">0 / 100</span>
                </div>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="input {{ $errors->has('title') ? 'error' : '' }}"
                    placeholder="e.g. JavaScript Fundamentals"
                    value="{{ old('title') }}"
                    maxlength="100"
                    oninput="document.getElementById('title-count').textContent = this.value.length + ' / 100'"
                    required
                >
                @error('title')
                    <div class="field-error">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="field">
                <label class="field-label" for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    class="textarea {{ $errors->has('description') ? 'error' : '' }}"
                    placeholder="What will this quiz test? Give learners an idea of what to expect…"
                >{{ old('description') }}</textarea>
                <div class="field-hint">Optional — shown to users before they attempt the quiz.</div>
                @error('description')
                    <div class="field-error">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-divider"></div>

            {{-- Status --}}
            <div class="field">
                <label class="field-label">Status <span class="required">*</span></label>
                <div class="status-options">

                    <div>
                        <input type="radio" name="status" id="status-draft" value="draft"
                               class="status-option"
                               {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}>
                        <label for="status-draft" class="status-label">
                            <div class="status-icon">
                                <!-- Draft (edit/pencil) icon -->
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2a2.828 2.828 0 0 1 4 4L7 21l-4 1 1-4L18 2z"/></svg>
                            </div>
                            <div>
                                <div class="status-text">Draft</div>
                                <div class="status-subtext">Not visible to others</div>
                            </div>
                        </label>
                    </div>

                    <div>
                        <input type="radio" name="status" id="status-published" value="published"
                               class="status-option"
                               {{ old('status') === 'published' ? 'checked' : '' }}>
                        <label for="status-published" class="status-label">
                            <div class="status-icon">
                                <!-- Published (check circle) icon -->
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2l4-4"/></svg>
                            </div>
                            <div>
                                <div class="status-text">Published</div>
                                <div class="status-subtext">Visible & open for attempts</div>
                            </div>
                        </label>
                    </div>

                </div>
                <div class="field-hint">You can always change this later from the quizzes dashboard.</div>
            </div>

        </div>

        {{-- Form footer --}}
        <div class="form-footer">
            <a href="{{ route('quizzes.index') }}" class="btn-ghost">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Cancel
            </a>
            <button type="submit" class="btn-gold">
                Create quiz & add questions
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>

    </div>
    </form>

</div>
</div>

@endsection