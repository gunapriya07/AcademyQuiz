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
        --green-bg: rgba(74,222,128,.08);
        --green-bdr:rgba(74,222,128,.2);
        --red:      #f87171;
        --red-bg:   rgba(248,113,113,.08);
        --red-bdr:  rgba(248,113,113,.2);
        --blue:     #60a5fa;
        --purple:   #a78bfa;
        --r:        12px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .qform-page {
        min-height: 100vh;
        background: var(--ink);
        color: var(--text);
        font-family: 'DM Sans', 'Segoe UI', sans-serif;
        font-weight: 300;
        padding-bottom: 80px;
    }

    .qform-page::before {
        content: '';
        position: fixed; inset: 0; z-index: 0; pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
    }

    .qform-layout {
        position: relative; z-index: 1;
        max-width: 1060px;
        margin: 0 auto;
        padding: 0 28px;
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 24px;
        align-items: start;
    }

    .qform-full { grid-column: 1 / -1; }

    /* ── HEADER ── */
    .qform-header {
        padding: 48px 0 32px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 32px;
        display: flex; align-items: flex-end; justify-content: space-between; gap: 16px;
    }

    .breadcrumb {
        display: flex; align-items: center; gap: 7px;
        font-size: 12px; color: var(--muted);
        margin-bottom: 12px;
    }

    .breadcrumb a { color: var(--muted); text-decoration: none; }
    .breadcrumb a:hover { color: var(--gold); }
    .breadcrumb span { color: var(--text); }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(22px, 3.5vw, 34px);
        font-weight: 700; line-height: 1.1;
        letter-spacing: -.025em;
    }

    .page-title em { font-style: italic; color: var(--gold); }
    .page-sub { margin-top: 6px; font-size: 13px; color: var(--muted); line-height: 1.6; }

    /* ── CARDS ── */
    .form-card {
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 16px;
        animation: fadeUp .4s ease both;
    }

    .form-card:nth-child(2) { animation-delay: .07s; }
    .form-card:nth-child(3) { animation-delay: .14s; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--line);
        display: flex; align-items: center; gap: 11px;
    }

    .card-icon {
        width: 36px; height: 36px;
        background: var(--gold-dim);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
        border: 1px solid var(--gold-bdr);
    }

    .card-htext h3 {
        font-family: 'Playfair Display', serif;
        font-size: 15px; font-weight: 700; letter-spacing: -.01em;
    }

    .card-htext p { font-size: 11px; color: var(--muted); margin-top: 1px; }

    .card-body { padding: 24px; }

    /* ── FIELD ── */
    .field { margin-bottom: 20px; }
    .field:last-of-type { margin-bottom: 0; }

    .field-label {
        display: block;
        font-size: 11px; font-weight: 500;
        letter-spacing: .8px; text-transform: uppercase;
        color: var(--muted); margin-bottom: 8px;
    }

    .field-label .req { color: var(--gold); margin-left: 2px; }
    .field-hint { font-size: 11px; color: var(--muted); margin-top: 5px; line-height: 1.5; }

    .input, .select, .textarea {
        width: 100%;
        background: var(--ink3);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: var(--r);
        padding: 11px 16px;
        color: var(--text);
        font-family: inherit; font-size: 14px; font-weight: 300;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        -webkit-appearance: none;
    }

    .input::placeholder, .textarea::placeholder { color: var(--muted); }

    .input:focus, .select:focus, .textarea:focus {
        border-color: rgba(201,168,76,.45);
        box-shadow: 0 0 0 3px rgba(201,168,76,.06);
    }

    .textarea { resize: vertical; min-height: 120px; line-height: 1.65; }

    .select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a8d9c' stroke-width='2' stroke-linecap='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }

    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .field-error { font-size: 11px; color: var(--red); margin-top: 5px; display: flex; align-items: center; gap: 5px; }

    /* ── TYPE SELECTOR ── */
    .type-grid {
        display: grid; grid-template-columns: repeat(5, 1fr);
        gap: 8px;
    }

    .type-radio { display: none; }

    .type-tile {
        display: flex; flex-direction: column; align-items: center;
        gap: 6px; padding: 12px 6px;
        background: var(--ink3);
        border: 1.5px solid rgba(255,255,255,.07);
        border-radius: var(--r);
        cursor: pointer;
        transition: all .2s;
        user-select: none;
    }

    .type-tile:hover { border-color: rgba(201,168,76,.3); background: var(--ink4); }

    .type-radio:checked + .type-tile {
        border-color: var(--gold);
        background: var(--gold-dim);
    }

    .type-emoji { font-size: 20px; }

    .type-name {
        font-size: 10px; font-weight: 500;
        letter-spacing: .4px; color: var(--muted);
        text-align: center; text-transform: uppercase;
    }

    .type-radio:checked + .type-tile .type-name { color: var(--gold); }

    /* ── MARKS STEPPER ── */
    .marks-stepper {
        display: flex; align-items: center; gap: 0;
        background: var(--ink3);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: var(--r);
        overflow: hidden; width: fit-content;
    }

    .step-btn {
        width: 40px; height: 42px;
        background: transparent;
        border: none; cursor: pointer;
        color: var(--muted);
        font-size: 18px; font-weight: 300;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s;
        font-family: inherit;
    }

    .step-btn:hover { background: var(--ink4); color: var(--gold); }

    .step-input {
        width: 56px; height: 42px;
        background: transparent;
        border: none; border-left: 1px solid rgba(255,255,255,.06); border-right: 1px solid rgba(255,255,255,.06);
        color: var(--text);
        font-family: 'Playfair Display', serif;
        font-size: 18px; font-weight: 700;
        text-align: center; outline: none;
        -moz-appearance: textfield;
    }

    .step-input::-webkit-outer-spin-button,
    .step-input::-webkit-inner-spin-button { -webkit-appearance: none; }

    /* ── TOOLBAR ── */
    .editor-toolbar {
        display: flex; gap: 2px;
        padding: 8px 10px;
        background: var(--ink4);
        border-radius: var(--r) var(--r) 0 0;
        border: 1px solid rgba(255,255,255,.07);
        border-bottom: none;
        flex-wrap: wrap;
    }

    .tool-btn {
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 12px; font-weight: 500;
        color: var(--muted); background: transparent;
        border: none; cursor: pointer; font-family: inherit;
        transition: all .15s;
    }

    .tool-btn:hover { background: var(--ink3); color: var(--text); }
    .tool-sep { width: 1px; background: rgba(255,255,255,.07); margin: 3px 5px; }

    .editor-area {
        border-radius: 0 0 var(--r) var(--r) !important;
        border-top: none !important;
    }

    /* ── OPTIONS ── */
    .options-container { display: flex; flex-direction: column; gap: 10px; }

    .option-row {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px;
        background: var(--ink3);
        border: 1.5px solid rgba(255,255,255,.06);
        border-radius: var(--r);
        transition: border-color .2s;
        animation: fadeUp .3s ease both;
    }

    .option-row:hover { border-color: rgba(255,255,255,.1); }
    .option-row.correct-row { border-color: rgba(74,222,128,.3) !important; background: var(--green-bg); }

    .correct-toggle {
        width: 20px; height: 20px; flex-shrink: 0;
        background: var(--ink4);
        border: 1.5px solid rgba(255,255,255,.1);
        border-radius: 5px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .18s;
    }

    .correct-toggle.checked {
        background: var(--green-bg);
        border-color: var(--green);
    }

    .correct-toggle.checked::after {
        content: '✓';
        font-size: 12px; font-weight: 700;
        color: var(--green);
    }

    .option-input {
        flex: 1;
        background: transparent;
        border: none; outline: none;
        color: var(--text);
        font-family: inherit; font-size: 13px; font-weight: 300;
    }

    .option-input::placeholder { color: var(--muted); }

    .option-drag {
        color: var(--muted); cursor: grab;
        font-size: 14px; letter-spacing: 1px;
        opacity: .4; flex-shrink: 0;
    }

    .option-remove {
        width: 24px; height: 24px; flex-shrink: 0;
        background: transparent;
        border: none; cursor: pointer;
        color: var(--muted);
        display: flex; align-items: center; justify-content: center;
        border-radius: 5px; transition: all .15s; font-family: inherit;
    }

    .option-remove:hover { background: var(--red-bg); color: var(--red); }

    .add-option-btn {
        display: flex; align-items: center; gap: 7px;
        padding: 9px 14px;
        background: var(--gold-dim);
        border: 1px dashed rgba(201,168,76,.25);
        border-radius: var(--r);
        color: var(--gold);
        font-family: inherit; font-size: 12px; font-weight: 400;
        cursor: pointer; width: 100%; justify-content: center;
        transition: all .2s;
    }

    .add-option-btn:hover { background: rgba(201,168,76,.15); border-color: rgba(201,168,76,.4); }

    /* ── TYPE HINT ── */
    .type-hint {
        display: flex; gap: 10px; align-items: flex-start;
        padding: 12px 14px;
        background: rgba(96,165,250,.06);
        border: 1px solid rgba(96,165,250,.15);
        border-radius: var(--r);
        margin-bottom: 16px;
        font-size: 12px; color: var(--blue); line-height: 1.5;
    }

    /* ── SIDEBAR ── */
    .sidebar { position: sticky; top: 24px; }

    .sidebar-card {
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 14px;
        animation: fadeUp .4s .2s ease both;
    }

    .sidebar-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--line);
        font-size: 11px; font-weight: 500;
        letter-spacing: .8px; text-transform: uppercase; color: var(--muted);
    }

    .sidebar-body { padding: 16px 18px; }

    .progress-row {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 8px;
    }

    .progress-bar {
        height: 4px; background: var(--ink4);
        border-radius: 2px; overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--gold), var(--gold2));
        border-radius: 2px;
    }

    .tip-row {
        display: flex; gap: 8px; align-items: flex-start;
        font-size: 12px; color: var(--muted); line-height: 1.55;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,.04);
    }

    .tip-row:last-child { border-bottom: none; padding-bottom: 0; }
    .tip-icon { flex-shrink: 0; margin-top: 1px; }

    /* ── FORM FOOTER ── */
    .form-footer-bar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 18px 24px;
        border-top: 1px solid var(--line);
        background: var(--ink2);
    }

    .btn-gold {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 22px;
        background: var(--gold); color: var(--ink);
        font-family: inherit; font-size: 13px; font-weight: 500;
        border-radius: 9px; border: none; cursor: pointer;
        transition: background .2s, transform .15s;
        text-decoration: none;
    }

    .btn-gold:hover { background: var(--gold2); transform: translateY(-1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 11px 18px;
        background: transparent; color: var(--muted);
        font-family: inherit; font-size: 13px; font-weight: 300;
        border-radius: 9px; border: 1px solid rgba(255,255,255,.08);
        cursor: pointer; text-decoration: none;
        transition: all .2s;
    }

    .btn-ghost:hover { border-color: rgba(255,255,255,.18); color: var(--text); }

    .btn-outline-gold {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 11px 18px;
        background: var(--gold-dim); color: var(--gold);
        font-family: inherit; font-size: 13px; font-weight: 400;
        border-radius: 9px; border: 1px solid var(--gold-bdr);
        cursor: pointer; text-decoration: none;
        transition: all .2s;
    }

    .btn-outline-gold:hover { background: rgba(201,168,76,.18); }

    @media (max-width: 800px) {
        .qform-layout { grid-template-columns: 1fr; padding: 0 16px; }
        .sidebar { position: static; }
        .type-grid { grid-template-columns: repeat(3, 1fr); }
        .qform-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="qform-page">
<div class="qform-layout">

    {{-- ── HEADER (full width) ── --}}
    <div class="qform-full">
        <div class="qform-header">
            <div>
                <div class="breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    <a href="{{ route('quizzes.index') }}">Quizzes</a>
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    <a href="{{ route('quizzes.show', $quiz->id) }}">{{ Str::limit($quiz->title, 28) }}</a>
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    <span>Add Question</span>
                </div>
                <h1 class="page-title">Add a question to <em>{{ Str::limit($quiz->title, 32) }}</em></h1>
                <p class="page-sub">Choose a question type, write your question, then set the correct answer(s).</p>
            </div>
        </div>
    </div>

    {{-- ── MAIN COLUMN ── --}}
    <div>
    <form method="POST" action="{{ route('quizzes.questions.store', $quiz->id) }}" id="question-form" enctype="multipart/form-data">
    @csrf

        {{-- ── QUESTION TYPE ── --}}
        <div class="form-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 13.255c0-1.355-1.09-2.455-2.435-2.455-.27 0-.53.045-.775.13a3.001 3.001 0 0 0-5.58-1.13 2.5 2.5 0 1 0-3.48 3.48 3.001 3.001 0 0 0 1.13 5.58c-.085.245-.13.505-.13.775C4.745 21 3.645 19.91 3.645 18.565c0-1.355 1.09-2.455 2.435-2.455.27 0 .53.045.775.13a3.001 3.001 0 0 0 5.58 1.13 2.5 2.5 0 1 0 3.48-3.48 3.001 3.001 0 0 0-1.13-5.58c.085-.245.13-.505.13-.775C19.255 3 20.355 4.09 20.355 5.435c0 1.355-1.09 2.455-2.435 2.455-.27 0-.53-.045-.775-.13a3.001 3.001 0 0 0-5.58-1.13 2.5 2.5 0 1 0-3.48 3.48 3.001 3.001 0 0 0 1.13 5.58c-.085.245-.13.505-.13.775C4.745 21 3.645 19.91 3.645 18.565z"/></svg>
                </div>
                <div class="card-htext">
                    <h3>Question type</h3>
                    <p>Pick the type that fits your question</p>
                </div>
            </div>
            <div class="card-body">
                <div class="type-grid">
                    @php
                        $types = [
                            ['value'=>'binary',          'svg'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/></svg>',  'label'=>'Binary'],
                            ['value'=>'single_choice',   'svg'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="6"/></svg>',  'label'=>'Single'],
                            ['value'=>'multiple_choice', 'svg'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M7 13l3 3 7-7"/></svg>',  'label'=>'Multiple'],
                            ['value'=>'number',          'svg'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><text x="4" y="17" font-size="14" font-family="monospace">#</text></svg>',  'label'=>'Number'],
                            ['value'=>'text',            'svg'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><text x="2" y="15" font-size="13" font-family="monospace">Aa</text></svg>', 'label'=>'Text'],
                        ];
                    @endphp
                    @foreach($types as $type)
                        <div>
                            <input type="radio" name="type" id="type-{{ $type['value'] }}"
                                   value="{{ $type['value'] }}" class="type-radio"
                                   {{ old('type', 'single_choice') === $type['value'] ? 'checked' : '' }}
                                   onchange="handleTypeChange()">
                            <label for="type-{{ $type['value'] }}" class="type-tile">
                                <span class="type-emoji">{!! $type['svg'] !!}</span>
                                <span class="type-name">{{ $type['label'] }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── QUESTION BODY ── --}}
        <div class="form-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M16.862 3.487a2.06 2.06 0 0 1 2.915 2.915l-9.193 9.193-3.02.105.105-3.02 9.193-9.193z"/><path d="M19.5 5.5l-1-1"/></svg>
                </div>
                <div class="card-htext">
                    <h3>Question text</h3>
                    <p>Write clearly — add media if needed</p>
                </div>
            </div>
            <div class="card-body">

                <div class="field">
                    <label class="field-label" for="body">Question body <span class="req">*</span></label>
                    <div class="editor-toolbar">
                        <button type="button" class="tool-btn" onclick="format('bold')"><b>B</b></button>
                        <button type="button" class="tool-btn" onclick="format('italic')"><i>I</i></button>
                        <button type="button" class="tool-btn" onclick="format('underline')" style="text-decoration:underline">U</button>
                        <div class="tool-sep"></div>
                        <button type="button" class="tool-btn" onclick="format('insertUnorderedList')">• List</button>
                        <button type="button" class="tool-btn" onclick="format('insertOrderedList')">1. List</button>
                        <div class="tool-sep"></div>
                        <button type="button" class="tool-btn" onclick="format('formatBlock','<code>')" style="font-family:monospace">Code</button>
                    </div>
                    <div id="body-editor" contenteditable="true" class="textarea editor-area"
                         style="min-height:120px"
                         oninput="syncBody()">{{ old('body') }}</div>
                    <input type="hidden" name="body" id="body-hidden" value="{{ old('body') }}">
                    @error('body')
                        <div class="field-error">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-row">
                    <div class="field">
                        <label class="field-label" for="image">Image <span style="color:var(--muted);font-size:10px;letter-spacing:0;text-transform:none">(optional)</span></label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="input" style="padding:8px 12px;cursor:pointer"
                               onchange="previewImage(this)">
                        <div id="img-preview" style="display:none;margin-top:8px">
                            <img id="img-thumb" src="" alt="" style="max-height:80px;border-radius:8px;border:1px solid var(--line)">
                        </div>
                    </div>
                    <div class="field">
                        <label class="field-label" for="video_url">Video URL <span style="color:var(--muted);font-size:10px;letter-spacing:0;text-transform:none">(YouTube, optional)</span></label>
                        <input type="url" name="video_url" id="video_url" class="input"
                               placeholder="https://youtube.com/watch?v=…"
                               value="{{ old('video_url') }}">
                    </div>
                </div>

            </div>
        </div>

        {{-- ── OPTIONS ── --}}
        <div class="form-card" id="options-card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M7 13l3 3 7-7"/></svg>
                </div>
                <div class="card-htext">
                    <h3>Answer options</h3>
                    <p>Click the checkbox to mark correct answers</p>
                </div>
            </div>
            <div class="card-body">

                <div id="type-hint" class="type-hint">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    <span id="type-hint-text">Select exactly one correct option for single choice questions.</span>
                </div>

                <div class="options-container" id="options-container">
                    <div class="option-row" data-index="0">
                        <span class="option-drag">⋮⋮</span>
                        <div class="correct-toggle" onclick="toggleCorrect(this)"></div>
                        <input type="hidden" name="options[0][is_correct]" value="0" class="is-correct-hidden">
                        <input type="text" name="options[0][text]" placeholder="Type option A…" class="option-input">
                        <button type="button" class="option-remove" onclick="removeOption(this)" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="option-row" data-index="1">
                        <span class="option-drag">⋮⋮</span>
                        <div class="correct-toggle" onclick="toggleCorrect(this)"></div>
                        <input type="hidden" name="options[1][is_correct]" value="0" class="is-correct-hidden">
                        <input type="text" name="options[1][text]" placeholder="Type option B…" class="option-input">
                        <button type="button" class="option-remove" onclick="removeOption(this)" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <button type="button" class="add-option-btn" id="add-opt-btn" onclick="addOption()" style="margin-top:12px">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                    Add option
                </button>

                {{-- Number / Text input answer area (hidden by default) --}}
                <div id="direct-answer" style="display:none">
                    <label class="field-label" for="correct_answer">Correct answer <span class="req">*</span></label>
                    <input type="text" name="correct_answer" id="correct_answer"
                           class="input" placeholder="Enter the expected answer…"
                           value="{{ old('correct_answer') }}">
                    <div class="field-hint" id="answer-hint">The exact value a correct response must match.</div>
                </div>

            </div>
        </div>

        {{-- ── FORM FOOTER ── --}}
        <div class="form-footer-bar" style="border-radius:0 0 16px 16px;border:1px solid var(--line);border-top:none;background:var(--ink2)">
            <a href="{{ route('quizzes.index') }}" class="btn-ghost">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Back to quizzes
            </a>
            <div style="display:flex;gap:10px">
                <button type="submit" name="action" value="save_add" class="btn-outline-gold">
                    Save & add another
                </button>
                <button type="submit" name="action" value="save" class="btn-gold">
                    Save question
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

    </form>
    </div>

    {{-- ── SIDEBAR ── --}}
    <div class="sidebar">

        {{-- Marks ── --}}
        <div class="sidebar-card">
            <div class="sidebar-header">Marks</div>
            <div class="sidebar-body">
                <div class="field-hint" style="margin-bottom:12px">Points awarded for a correct answer.</div>
                <div class="marks-stepper">
                    <button type="button" class="step-btn" onclick="adjustMarks(-1)">−</button>
                    <input type="number" name="marks" id="marks-input" class="step-input"
                           value="{{ old('marks', 1) }}" min="1" max="100" form="question-form">
                    <button type="button" class="step-btn" onclick="adjustMarks(1)">+</button>
                </div>
            </div>
        </div>

        {{-- Quiz info ── --}}
        <div class="sidebar-card">
            <div class="sidebar-header">Quiz info</div>
            <div class="sidebar-body" style="display:flex;flex-direction:column;gap:10px">
                <div style="font-size:13px;font-weight:500">{{ $quiz->title }}</div>
                <div style="font-size:12px;color:var(--muted);line-height:1.5">{{ Str::limit($quiz->description, 80) }}</div>
                <div style="display:flex;align-items:center;gap:8px;margin-top:4px">
                    <span style="font-size:11px;padding:3px 10px;border-radius:20px;background:var(--green-bg);color:var(--green);border:1px solid var(--green-bdr)">
                        {{ $quiz->questions->count() }} questions so far
                    </span>
                </div>
            </div>
        </div>

        {{-- Tips ── --}}
        <div class="sidebar-card">
            <div class="sidebar-header">Tips</div>
            <div class="sidebar-body">
                <div class="tip-row">
                    <span class="tip-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/></svg></span>
                    <span><strong style="color:var(--text)">Binary</strong> — auto-generates Yes/No options. Just mark the correct one.</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="6"/></svg></span>
                    <span><strong style="color:var(--text)">Single</strong> — mark exactly one option as correct.</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M7 13l3 3 7-7"/></svg></span>
                    <span><strong style="color:var(--text)">Multiple</strong> — mark all correct options. Partial selections score 0.</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><text x="4" y="17" font-size="14" font-family="monospace">#</text></svg></span>
                    <span><strong style="color:var(--text)">Number</strong> — enter the exact expected numeric answer.</span>
                </div>
                <div class="tip-row">
                    <span class="tip-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><text x="2" y="15" font-size="13" font-family="monospace">Aa</text></svg></span>
                    <span><strong style="color:var(--text)">Text</strong> — any non-empty answer is accepted unless you specify one.</span>
                </div>
            </div>
        </div>

    </div>

</div>
</div>

<script>
let optionIndex = 2;
const hints = {
    binary:          'Binary questions auto-generate Yes / No options. Mark one as correct.',
    single_choice:   'Select exactly one correct option.',
    multiple_choice: 'Select all options that are correct. Students must pick them all to score.',
    number:          'Enter the exact numeric answer expected.',
    text:            'Any non-empty text is accepted, or enter a specific expected answer.',
};
const placeholders = ['Type option A…','Type option B…','Type option C…','Type option D…','Type option E…'];

function handleTypeChange() {
    const type = document.querySelector('input[name="type"]:checked')?.value || 'single_choice';
    const optCard   = document.getElementById('options-card');
    const directAns = document.getElementById('direct-answer');
    const addBtn    = document.getElementById('add-opt-btn');
    const hintEl    = document.getElementById('type-hint-text');
    const container = document.getElementById('options-container');

    hintEl.textContent = hints[type] || '';

    if (type === 'number' || type === 'text') {
        optCard.querySelector('.options-container').style.display = 'none';
        addBtn.style.display = 'none';
        directAns.style.display = 'block';
        document.getElementById('answer-hint').textContent =
            type === 'number' ? 'Must be a numeric value.' : 'Leave blank to accept any non-empty text.';
        document.getElementById('correct_answer').type = type === 'number' ? 'number' : 'text';
    } else {
        container.style.display = 'flex';
        addBtn.style.display = 'flex';
        directAns.style.display = 'none';

        if (type === 'binary') {
            container.innerHTML = '';
            ['Yes','No'].forEach((val, i) => addOptionWithValue(val, i));
            addBtn.style.display = 'none';
            optionIndex = 2;
        }
    }
}

function addOptionWithValue(val, idx) {
    const container = document.getElementById('options-container');
    const ph = placeholders[idx] || `Option ${idx + 1}…`;
    const div = document.createElement('div');
    div.className = 'option-row';
    div.dataset.index = idx;
    div.innerHTML = `
        <span class="option-drag">⋮⋮</span>
        <div class="correct-toggle" onclick="toggleCorrect(this)"></div>
        <input type="hidden" name="options[${idx}][is_correct]" value="0" class="is-correct-hidden">
        <input type="text" name="options[${idx}][text]" placeholder="${ph}" class="option-input" value="${val}">
        <button type="button" class="option-remove" onclick="removeOption(this)" title="Remove">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>`;
    container.appendChild(div);
}

function addOption() {
    const container = document.getElementById('options-container');
    const idx = optionIndex;
    const ph  = placeholders[idx] || `Option ${idx + 1}…`;
    const div = document.createElement('div');
    div.className = 'option-row';
    div.dataset.index = idx;
    div.innerHTML = `
        <span class="option-drag">⋮⋮</span>
        <div class="correct-toggle" onclick="toggleCorrect(this)"></div>
        <input type="hidden" name="options[${idx}][is_correct]" value="0" class="is-correct-hidden">
        <input type="text" name="options[${idx}][text]" placeholder="${ph}" class="option-input">
        <button type="button" class="option-remove" onclick="removeOption(this)" title="Remove">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>`;
    container.appendChild(div);
    div.querySelector('.option-input').focus();
    optionIndex++;
}

function removeOption(btn) {
    const row = btn.closest('.option-row');
    if (document.querySelectorAll('.option-row').length <= 1) return;
    row.style.opacity = '0'; row.style.transform = 'translateX(8px)';
    row.style.transition = 'all .2s';
    setTimeout(() => row.remove(), 200);
}

function toggleCorrect(toggle) {
    const isChecked = toggle.classList.toggle('checked');
    const row = toggle.closest('.option-row');
    const hiddenInput = row.querySelector('.is-correct-hidden');
    hiddenInput.value = isChecked ? '1' : '0';
    row.classList.toggle('correct-row', isChecked);
}

function adjustMarks(delta) {
    const input = document.getElementById('marks-input');
    const val = Math.max(1, Math.min(100, parseInt(input.value || 1) + delta));
    input.value = val;
}

function format(cmd, val) {
    document.execCommand(cmd, false, val || null);
    document.getElementById('body-editor').focus();
    syncBody();
}

function syncBody() {
    document.getElementById('body-hidden').value = document.getElementById('body-editor').innerHTML;
}

function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const thumb   = document.getElementById('img-thumb');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { thumb.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    handleTypeChange();
    document.querySelector('input[name="type"]:checked')
        ?.closest('.type-tile')?.parentElement;
});
</script>

@endsection