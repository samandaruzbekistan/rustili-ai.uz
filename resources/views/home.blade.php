@extends('layouts.kids')

@section('title', 'Bosh sahifa')

@section('content')
    {{-- Hero section --}}
    <section class="hero">
        <h1 class="hero-title">🌈 Bolalar uchun onlayn kutubxona</h1>
        <p class="hero-subtitle">
            Ertaklar, she'rlar, topishmoqlar, multfilmlar va ko'p narsalar! 
            <br>Сказки, стихи, загадки, мультфильмы и многое другое!
        </p>
    </section>

    {{-- Chapters grid --}}
    <section>
        <div class="section-header">
            <h2 class="section-title">📖 Barcha bo'limlar / Все разделы</h2>
        </div>
        
        <div class="cards-grid">
            @forelse($chapters as $chapter)
                <a href="{{ locale_url('chapter.show', ['slug' => $chapter->slug]) }}" class="card">
                    <div class="card-image">
                        @if($chapter->cover_image)
                            <img src="{{ Storage::url($chapter->cover_image) }}" alt="{{ $chapter->title_ru }}">
                        @else
                            <span class="card-icon">{{ $chapter->icon ?? '📚' }}</span>
                        @endif
            </div>
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ $chapter->icon }} {{ current_locale() === 'uz' && $chapter->title_uz ? $chapter->title_uz : $chapter->title_ru }}
                        </h3>
                        {{-- @if(current_locale() === 'ru' && $chapter->title_uz)
                            <p class="card-subtitle">{{ $chapter->title_uz }}</p>
                        @elseif(current_locale() === 'uz' && $chapter->title_ru)
                            <p class="card-subtitle">{{ $chapter->title_ru }}</p>
                        @endif --}}
                        @if($chapter->description)
                            <p class="card-description">{{ Str::limit(strip_tags($chapter->description), 100) }}</p>
                        @endif
                        <div class="card-meta">
                            @if($chapter->sections_count > 0)
                                <span class="card-badge">📁 {{ $chapter->sections_count }} bo'lim</span>
                            @endif
                            @if($chapter->contents_count > 0)
                                <span class="card-badge">📄 {{ $chapter->contents_count }} material</span>
                            @endif
    </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <p style="font-size: 1.25rem; color: var(--color-text-light);">
                        😔 Hozircha bo'limlar yo'q / Пока нет разделов
                    </p>
                </div>
        @endforelse
        </div>
    </section>
@endsection
