@extends('layouts.app')

@section('content')

<style>
    :root {
        --ink:      #0b0d10;
        --ink2:     #131720;
        --ink3:     #1c2130;
        --surface:  #212840;
        --gold:     #c9a84c;
        --gold2:    #e8c96a;
        --gold-dim: #c9a84c22;
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
        --blue-bg:  rgba(96,165,250,.08);
        --r: 12px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    .qz-page {
        min-height: 100vh;
        background: var(--ink);
        color: var(--text);
        font-family: 'DM Sans', 'Segoe UI', sans-serif;
        font-weight: 300;
        padding-bottom: 80px;
    }

    /* noise overlay */
    .qz-page::before {
        content: '';
        position: fixed; inset: 0; z-index: 0; pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
    }

    .qz-inner { position: relative; z-index: 1; max-width: 1100px; margin: 0 auto; padding: 0 32px; }

    /* ── PAGE HEADER ── */
    .qz-header {
        padding: 52px 0 40px;
        border-bottom: 1px solid var(--line);
        display: flex; align-items: flex-end; justify-content: space-between; gap: 24px;
    }

    .qz-breadcrumb {
        display: flex; align-items: center; gap: 7px;
        font-size: 12px; color: var(--muted);
        margin-bottom: 12px; letter-spacing: .3px;
    }

    .qz-breadcrumb a { color: var(--muted); text-decoration: none; }
    .qz-breadcrumb a:hover { color: var(--gold); }
    .qz-breadcrumb span { color: var(--text); }

    .qz-page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(26px, 4vw, 38px);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -.025em;
    }

    .qz-page-title em { font-style: italic; color: var(--gold); }

    .qz-page-sub {
        margin-top: 8px;
        font-size: 14px; color: var(--muted); line-height: 1.6;
    }

    .btn-gold {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 22px;
        background: var(--gold);
        color: var(--ink);
        font-family: inherit;
        font-size: 13px; font-weight: 500;
        border-radius: 9px;
        text-decoration: none;
        border: none; cursor: pointer;
        white-space: nowrap;
        transition: background .2s, transform .15s;
        flex-shrink: 0;
    }

    .btn-gold:hover { background: var(--gold2); transform: translateY(-1px); }

    .btn-outline {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px;
        background: transparent;
        color: var(--muted);
        font-family: inherit;
        font-size: 12px; font-weight: 400;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid var(--line);
        cursor: pointer;
        transition: all .2s;
    }

    .btn-outline:hover { border-color: rgba(201,168,76,.35); color: var(--gold); }

    .btn-danger {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px;
        background: var(--red-bg);
        color: var(--red);
        font-family: inherit;
        font-size: 12px; font-weight: 400;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid var(--red-bdr);
        cursor: pointer;
        transition: all .2s;
    }

    .btn-danger:hover { background: rgba(248,113,113,.15); }

    /* ── STATS ROW ── */
    .qz-stats {
        display: flex; gap: 12px;
        padding: 28px 0;
        border-bottom: 1px solid var(--line);
    }

    .stat-pill {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 20px;
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 10px;
        flex: 1;
    }

    .stat-icon {
        width: 36px; height: 36px;
        background: var(--gold-dim);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }

    .stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 700;
        color: var(--gold); line-height: 1;
    }

    .stat-lbl { font-size: 11px; color: var(--muted); margin-top: 2px; }

    /* ── TOOLBAR ── */
    .qz-toolbar {
        display: flex; align-items: center; gap: 10px;
        padding: 24px 0 20px;
    }

    .search-box {
        flex: 1; position: relative; max-width: 320px;
    }

    .search-box svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--muted); pointer-events: none;
    }

    .search-input {
        width: 100%;
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 9px 14px 9px 36px;
        color: var(--text);
        font-family: inherit; font-size: 13px;
        outline: none; transition: border-color .2s;
    }

    .search-input::placeholder { color: var(--muted); }
    .search-input:focus { border-color: rgba(201,168,76,.4); }

    .filter-select {
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 9px 14px;
        color: var(--muted);
        font-family: inherit; font-size: 13px;
        outline: none; cursor: pointer;
        transition: border-color .2s;
    }

    .filter-select:focus { border-color: rgba(201,168,76,.4); }

    .toolbar-right { margin-left: auto; display: flex; gap: 8px; }

    .view-btn {
        width: 34px; height: 34px;
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--muted);
        transition: all .2s;
    }

    .view-btn.active, .view-btn:hover { border-color: rgba(201,168,76,.35); color: var(--gold); }

    /* ── GRID VIEW ── */
    .quiz-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        gap: 16px;
    }

    .quiz-card {
        background: var(--ink2);
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        transition: border-color .25s, transform .2s;
        position: relative;
        display: flex; flex-direction: column;
        animation: fadeUp .45s ease both;
    }

    .quiz-card:hover { border-color: rgba(201,168,76,.32); transform: translateY(-3px); }

    .quiz-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 2px;
        opacity: 0; transition: opacity .3s;
    }

    .quiz-card:hover::before { opacity: 1; }
    .quiz-card.active-card::before { background: linear-gradient(90deg, var(--green), transparent); }
    .quiz-card.draft-card::before  { background: linear-gradient(90deg, #60a5fa, transparent); }

    .card-top {
        padding: 22px 22px 16px;
        flex: 1;
    }

    .card-head {
        display: flex; align-items: flex-start; justify-content: space-between; gap: 10px;
        margin-bottom: 12px;
    }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 10px; font-weight: 500; letter-spacing: .5px;
        padding: 3px 10px; border-radius: 20px;
        white-space: nowrap; flex-shrink: 0;
    }

    .status-active { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-bdr); }
    .status-draft  { background: var(--blue-bg);  color: var(--blue);  border: 1px solid rgba(96,165,250,.2); }

    .status-dot {
        width: 5px; height: 5px; border-radius: 50%;
    }

    .status-active .status-dot { background: var(--green); animation: pulse 2s infinite; }
    .status-draft  .status-dot { background: var(--blue); }

    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

    .card-menu {
        position: relative;
    }

    .menu-trigger {
        width: 28px; height: 28px;
        background: var(--ink3);
        border: 1px solid var(--line);
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--muted);
        transition: all .15s; flex-shrink: 0;
        font-size: 14px; letter-spacing: 1px;
    }

    .menu-trigger:hover { border-color: rgba(201,168,76,.3); color: var(--gold); }

    .dropdown {
        display: none;
        position: absolute; top: 34px; right: 0;
        background: var(--ink3);
        border: 1px solid var(--line);
        border-radius: 10px;
        min-width: 170px;
        z-index: 50;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,.4);
    }

    .dropdown.open { display: block; }

    .dropdown-item {
        display: flex; align-items: center; gap: 9px;
        padding: 10px 14px;
        font-size: 13px; color: var(--muted);
        text-decoration: none;
        transition: all .15s;
        cursor: pointer;
        border: none; background: none; width: 100%; text-align: left;
        font-family: inherit;
    }

    .dropdown-item:hover { background: rgba(201,168,76,.07); color: var(--text); }
    .dropdown-item.danger { color: var(--red); }
    .dropdown-item.danger:hover { background: var(--red-bg); }
    .dropdown-sep { height: 1px; background: var(--line); margin: 4px 0; }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 17px; font-weight: 700;
        line-height: 1.3; letter-spacing: -.01em;
        margin-bottom: 8px;
    }

    .card-desc {
        font-size: 12.5px; color: var(--muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 22px;
        border-top: 1px solid var(--line);
        flex-wrap: wrap;
    }

    .meta-chip {
        display: flex; align-items: center; gap: 5px;
        font-size: 11px; color: var(--muted);
    }

    .meta-chip svg { flex-shrink: 0; }

    .card-actions {
        display: flex; gap: 8px;
        padding: 14px 22px;
        border-top: 1px solid var(--line);
    }

    .action-btn {
        flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 8px;
        border-radius: 8px;
        font-size: 12px; font-weight: 400;
        text-decoration: none;
        border: 1px solid var(--line);
        color: var(--muted);
        background: transparent;
        transition: all .18s;
        cursor: pointer; font-family: inherit;
    }

    .action-btn:hover { border-color: rgba(201,168,76,.3); color: var(--gold); background: var(--gold-dim); }

    .action-btn.primary-action {
        background: var(--gold-dim);
        border-color: var(--gold-bdr);
        color: var(--gold);
    }

    .action-btn.primary-action:hover { background: rgba(201,168,76,.2); }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
        border: 1px dashed rgba(201,168,76,.2);
        border-radius: 16px;
        background: var(--ink2);
    }

    .empty-icon {
        width: 72px; height: 72px;
        background: var(--gold-dim);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px;
        font-size: 30px;
    }

    .empty-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 700; margin-bottom: 10px;
    }

    .empty-sub { font-size: 14px; color: var(--muted); margin-bottom: 28px; line-height: 1.6; }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 700px) {
        .qz-inner { padding: 0 16px; }
        .qz-header { flex-direction: column; align-items: flex-start; }
        .qz-stats { flex-wrap: wrap; }
        .stat-pill { min-width: calc(50% - 6px); }
        .quiz-grid { grid-template-columns: 1fr; }
        .qz-toolbar { flex-wrap: wrap; }
        .search-box { max-width: 100%; flex: 1 1 100%; }
    }
</style>

<div class="qz-page">
<div class="qz-inner">

    {{-- ── PAGE HEADER ── --}}
    <div class="qz-header">
        <div>
            <div class="qz-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                <span>Quizzes</span>
            </div>
            <h1 class="qz-page-title">Your <em>Quizzes</em></h1>
            <p class="qz-page-sub">Create, manage, and share your assessments from one place.</p>
        </div>
        <a href="{{ route('quizzes.create') }}" class="btn-gold">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            New quiz
        </a>
    </div>

    {{-- ── STATS ROW ── --}}
    <div class="qz-stats">
        <div class="stat-pill">
            <div class="stat-icon">📋</div>
            <div>
                <div class="stat-val">{{ $quizzes->count() }}</div>
                <div class="stat-lbl">Total quizzes</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2l4-4"/></svg></div>
            <div>
                <div class="stat-val">{{ $quizzes->where('status','active')->count() }}</div>
                <div class="stat-lbl">Active</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="4" rx="1"/><rect x="4" y="7" width="16" height="15" rx="2"/><path d="M9 2v4"/><path d="M15 2v4"/></svg></div>
            <div>
                <div class="stat-val">{{ $quizzes->where('status','draft')->count() }}</div>
                <div class="stat-lbl">Drafts</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><circle cx="12" cy="16" r="1"/></svg></div>
            <div>
                <div class="stat-val">{{ $quizzes->sum(fn($q) => $q->questions_count ?? 0) }}</div>
                <div class="stat-lbl">Total questions</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="qz-toolbar">
        <div class="search-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input class="search-input" type="text" id="quiz-search" placeholder="Search quizzes…" autocomplete="off">
        </div>
        <select class="filter-select" id="status-filter" onchange="filterQuizzes()">
            <option value="all">All statuses</option>
            <option value="active">Active</option>
            <option value="draft">Draft</option>
        </select>
        <div class="toolbar-right">
            <div class="view-btn active" id="grid-btn" onclick="setView('grid')" title="Grid view">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            </div>
            <div class="view-btn" id="list-btn" onclick="setView('list')" title="List view">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
            </div>
        </div>
    </div>

    {{-- ── QUIZ GRID ── --}}
    @if($quizzes->count() > 0)
    <div class="quiz-grid" id="quiz-container">
        @foreach($quizzes as $i => $quiz)
        <div class="quiz-card {{ $quiz->status === 'active' ? 'active-card' : 'draft-card' }}"
             data-title="{{ strtolower($quiz->title) }}"
             data-status="{{ $quiz->status }}"
             style="animation-delay: {{ $i * 0.07 }}s">

            <div class="card-top">
                <div class="card-head">
                    @if($quiz->status === 'active')
                        <span class="status-badge status-active">
                            <span class="status-dot"></span> Active
                        </span>
                    @else
                        <span class="status-badge status-draft">
                            <span class="status-dot"></span> Draft
                        </span>
                    @endif

                    <div class="card-menu">
                        <div class="menu-trigger" onclick="toggleMenu('menu-{{ $quiz->id }}', event)">···</div>
                        <div class="dropdown" id="menu-{{ $quiz->id }}">
                            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="dropdown-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit details
                            </a>
                            <a href="{{ route('quizzes.questions.create', $quiz->id) }}" class="dropdown-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                                Add question
                            </a>
                            <a href="{{ route('quizzes.attempt', $quiz->id) }}" class="dropdown-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                Attempt quiz
                            </a>
                            <div class="dropdown-sep"></div>
                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST"
                                  onsubmit="return confirm('Delete \'{{ addslashes($quiz->title) }}\'? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="dropdown-item danger">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Delete quiz
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-title">{{ $quiz->title }}</div>
                @if($quiz->description)
                    <div class="card-desc">{{ $quiz->description }}</div>
                @endif
            </div>

            <div class="card-meta">
                <span class="meta-chip">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/></svg>
                    {{ $quiz->questions_count ?? $quiz->questions->count() }} questions
                </span>
                <span class="meta-chip">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    {{ $quiz->questions->sum('marks') ?? ($quiz->questions_count ?? 0) }} marks
                </span>
                <span class="meta-chip">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $quiz->created_at->diffForHumans() }}
                </span>
            </div>

            <div class="card-actions">
                <a href="{{ route('quizzes.questions.create', $quiz->id) }}" class="action-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                    Questions
                </a>
                <a href="{{ route('quizzes.edit', $quiz->id) }}" class="action-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
                <a href="{{ route('quizzes.attempt', $quiz->id) }}" class="action-btn primary-action">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Attempt
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── EMPTY SEARCH RESULT ── --}}
    <div id="no-results" style="display:none">
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <div class="empty-title">No quizzes found</div>
            <div class="empty-sub">Try a different search term or clear your filters.</div>
            <button class="btn-gold" onclick="clearSearch()" style="margin:0 auto">Clear search</button>
        </div>
    </div>

    @else
    {{-- ── EMPTY STATE ── --}}
    <div class="empty-state" style="margin-top: 24px">
        <div class="empty-icon">📋</div>
        <div class="empty-title">No quizzes yet</div>
        <div class="empty-sub">Create your first quiz and start adding questions.<br>It only takes a minute.</div>
        <a href="{{ route('quizzes.create') }}" class="btn-gold" style="display:inline-flex;margin:0 auto">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
            Create your first quiz
        </a>
    </div>
    @endif

</div>
</div>

<script>
    // ── Search & filter
    const searchInput  = document.getElementById('quiz-search');
    const statusFilter = document.getElementById('status-filter');
    const cards        = document.querySelectorAll('.quiz-card');
    const noResults    = document.getElementById('no-results');

    function filterQuizzes() {
        const q      = searchInput  ? searchInput.value.toLowerCase().trim() : '';
        const status = statusFilter ? statusFilter.value : 'all';
        let visible  = 0;

        cards.forEach(card => {
            const titleMatch  = card.dataset.title.includes(q);
            const statusMatch = status === 'all' || card.dataset.status === status;
            const show = titleMatch && statusMatch;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    function clearSearch() {
        if (searchInput)  searchInput.value = '';
        if (statusFilter) statusFilter.value = 'all';
        filterQuizzes();
    }

    if (searchInput)  searchInput.addEventListener('input', filterQuizzes);

    // ── Dropdown menus
    function toggleMenu(id, e) {
        e.stopPropagation();
        document.querySelectorAll('.dropdown').forEach(d => {
            if (d.id !== id) d.classList.remove('open');
        });
        document.getElementById(id).classList.toggle('open');
    }

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
    });

    // ── Grid / List view toggle
    function setView(mode) {
        const grid    = document.getElementById('quiz-container');
        const gridBtn = document.getElementById('grid-btn');
        const listBtn = document.getElementById('list-btn');
        if (!grid) return;

        if (mode === 'list') {
            grid.style.gridTemplateColumns = '1fr';
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        } else {
            grid.style.gridTemplateColumns = '';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        }
    }
</script>

@endsection