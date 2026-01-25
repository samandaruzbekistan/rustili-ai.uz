@extends('layouts.kids')

@section('title', current_locale() === 'uz' && $chapter->title_uz ? $chapter->title_uz : $chapter->title_ru)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ locale_url('home') }}">🏠 {{ current_locale() === 'uz' ? 'Bosh sahifa' : 'Главная' }}</a>
        <span class="breadcrumb-separator">›</span>
        <span>{{ current_locale() === 'uz' && $chapter->title_uz ? $chapter->title_uz : $chapter->title_ru }}</span>
    </nav>

    {{-- Banner --}}
    <div class="banner">
        @if($chapter->cover_image)
            <img src="{{ Storage::url($chapter->cover_image) }}" alt="{{ $chapter->title_ru }}">
        @endif
        <div class="banner-overlay">
            <h1 class="banner-title">{{ $chapter->icon }} {{ current_locale() === 'uz' && $chapter->title_uz ? $chapter->title_uz : $chapter->title_ru }}</h1>
            @if(current_locale() === 'ru' && $chapter->title_uz)
                <p class="banner-subtitle">{{ $chapter->title_uz }}</p>
            @elseif(current_locale() === 'uz' && $chapter->title_ru)
                <p class="banner-subtitle">{{ $chapter->title_ru }}</p>
            @endif
        </div>
    </div>

    {{-- Description --}}
    @if($chapter->description)
        <p style="margin-bottom: var(--space-lg); font-size: 1.1rem; color: var(--color-text-light);">
            {{ $chapter->description }}
        </p>
    @endif

    {{-- Contents grid --}}
    <section>
        <div class="section-header">
            <h2 class="section-title">📄 {{ current_locale() === 'uz' ? 'Materiallar' : 'Материалы' }}</h2>
        </div>
        
        <div class="cards-grid">
            @forelse($contents as $content)
                <a href="{{ locale_url('content.show', ['id' => $content->id]) }}" class="card">
                    <div class="card-image">
                        @if($content->cover_image)
                            <img src="{{ Storage::url($content->cover_image) }}" alt="{{ $content->title_ru }}">
                        @else
                            <span class="card-icon">{{ $content->type_icon }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ current_locale() === 'uz' && $content->title_uz ? $content->title_uz : $content->title_ru }}</h3>
                        @if(current_locale() === 'ru' && $content->title_uz)
                            <p class="card-subtitle">{{ $content->title_uz }}</p>
                        @elseif(current_locale() === 'uz' && $content->title_ru)
                            <p class="card-subtitle">{{ $content->title_ru }}</p>
                        @endif
                        <div class="card-meta">
                            <span class="card-badge">
                                {{ $content->type_icon }}
                                @switch($content->type)
                                    @case('audio')
                                        Audio
                                        @break
                                    @case('video')
                                        Video
                                        @break
                                    @case('text')
                                        {{ current_locale() === 'uz' ? 'Matn' : 'Текст' }}
                                        @break
                                    @case('file')
                                        {{ current_locale() === 'uz' ? 'Fayl' : 'Файл' }}
                                        @break
                                    @case('test')
                                        Test
                                        @break
                                    @case('image')
                                        {{ current_locale() === 'uz' ? 'Rasm' : 'Изображение' }}
                                        @break
                                    @default
                                        {{ current_locale() === 'uz' ? 'Aralash' : 'Смешанный' }}
                                @endswitch
                            </span>
                            @if($content->age_range)
                                <span class="card-badge">👶 {{ $content->age_range }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <p style="font-size: 1.25rem; color: var(--color-text-light);">
                        😔 {{ current_locale() === 'uz' ? 'Hozircha materiallar yo\'q' : 'Пока нет материалов' }}
                    </p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
