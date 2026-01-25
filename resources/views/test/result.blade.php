@extends('layouts.kids')

@section('title', 'Test natijasi - ' . $test->title)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">🏠 Bosh sahifa</a>
        <span class="breadcrumb-separator">›</span>
        @if($test->content)
            <a href="{{ route('content.show', $test->content->id) }}">{{ $test->content->title_ru }}</a>
            <span class="breadcrumb-separator">›</span>
        @endif
        <span>Natija</span>
    </nav>

    {{-- Result container --}}
    <div class="content-detail" style="text-align: center;">
        <div style="font-size: 6rem; margin-bottom: var(--space-md);">
            @if($attempt->percentage >= 80)
                🎉
            @elseif($attempt->percentage >= 60)
                👍
            @elseif($attempt->percentage >= 40)
                🤔
            @else
                😅
            @endif
        </div>
        
        <h1 style="font-family: 'Comfortaa', cursive; font-size: 2rem; margin-bottom: var(--space-sm);">
            {{ $test->title }} - Natija
        </h1>
        
        <p style="font-size: 4rem; font-weight: 700; color: var(--color-primary); margin: var(--space-lg) 0;">
            {{ $attempt->percentage }}%
        </p>
        
        <div style="display: flex; justify-content: center; gap: var(--space-lg); flex-wrap: wrap; margin-bottom: var(--space-xl);">
            <div style="padding: var(--space-md); background: var(--color-bg-section); border-radius: var(--radius-md);">
                <p style="font-size: 2rem; font-weight: 700; color: var(--color-primary);">{{ $attempt->correct_answers }}</p>
                <p style="font-size: 0.875rem; color: var(--color-text-light);">To'g'ri javoblar</p>
            </div>
            <div style="padding: var(--space-md); background: var(--color-bg-section); border-radius: var(--radius-md);">
                <p style="font-size: 2rem; font-weight: 700; color: var(--color-secondary);">{{ $attempt->total_questions - $attempt->correct_answers }}</p>
                <p style="font-size: 0.875rem; color: var(--color-text-light);">Noto'g'ri</p>
            </div>
            <div style="padding: var(--space-md); background: var(--color-bg-section); border-radius: var(--radius-md);">
                <p style="font-size: 2rem; font-weight: 700; color: var(--color-text);">{{ $attempt->total_questions }}</p>
                <p style="font-size: 0.875rem; color: var(--color-text-light);">Jami savollar</p>
            </div>
        </div>
        
        @if($attempt->formatted_duration)
            <p style="color: var(--color-text-light); margin-bottom: var(--space-lg);">
                ⏱️ Vaqt: {{ $attempt->formatted_duration }}
            </p>
        @endif
        
        <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('test.show', $test->id) }}" class="btn btn-primary">
                🔄 Qayta urinish
            </a>
            @if($test->content)
                <a href="{{ route('content.show', $test->content->id) }}" class="btn btn-outline">
                    ← Orqaga qaytish
                </a>
            @else
                <a href="{{ route('home') }}" class="btn btn-outline">
                    🏠 Bosh sahifaga
                </a>
            @endif
        </div>
    </div>
@endsection

