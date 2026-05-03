@extends('layouts.app')

@section('content')
<div style="max-width:700px;margin:60px auto 0 auto;padding:32px 24px;background:var(--ink2);border-radius:18px;box-shadow:0 4px 24px #0002;">
    <h1 style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;margin-bottom:18px;color:var(--gold)">Dashboard</h1>
    <p style="color:var(--text);font-size:1.1rem;margin-bottom:24px;">Welcome to your dashboard. Here you can manage your quizzes and view your activity.</p>
    <div style="margin-top:32px;">
        <a href="/quizzes" class="btn-outline">Go to Quizzes</a>
    </div>
</div>
@endsection
