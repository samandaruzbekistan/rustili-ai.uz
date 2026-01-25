@extends('layouts.kids')

@section('title', current_locale() === 'uz' && $content->title_uz ? $content->title_uz : $content->title_ru)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ locale_url('home') }}">🏠 {{ current_locale() === 'uz' ? 'Bosh sahifa' : 'Главная' }}</a>
        <span class="breadcrumb-separator">›</span>
        <a href="{{ locale_url('chapter.show', ['slug' => $content->chapter->slug]) }}">
            {{ current_locale() === 'uz' && $content->chapter->title_uz ? $content->chapter->title_uz : $content->chapter->title_ru }}
        </a>
        @if($content->section)
            <span class="breadcrumb-separator">›</span>
            <a href="{{ locale_url('section.show', ['chapterSlug' => $content->chapter->slug, 'sectionSlug' => $content->section->slug]) }}">
                {{ current_locale() === 'uz' && $content->section->title_uz ? $content->section->title_uz : $content->section->title_ru }}
            </a>
        @endif
        <span class="breadcrumb-separator">›</span>
        <span>{{ Str::limit(current_locale() === 'uz' && $content->title_uz ? $content->title_uz : $content->title_ru, 30) }}</span>
    </nav>

    {{-- Content detail --}}
    <article class="content-detail">
        {{-- Header --}}
        <header class="content-header">
            <h1 class="content-title">{{ $content->type_icon }} {{ current_locale() === 'uz' && $content->title_uz ? $content->title_uz : $content->title_ru }}</h1>
            @if(current_locale() === 'ru' && $content->title_uz)
                <p style="font-size: 1.1rem; color: var(--color-text-light); margin-bottom: var(--space-sm);">
                    {{ $content->title_uz }}
                </p>
            @elseif(current_locale() === 'uz' && $content->title_ru)
                <p style="font-size: 1.1rem; color: var(--color-text-light); margin-bottom: var(--space-sm);">
                    {{ $content->title_ru }}
                </p>
            @endif
            <div class="content-meta">
                <span class="card-badge">
                    @switch($content->type)
                        @case('audio')
                            🎧 Audio ertak
                            @break
                        @case('video')
                            🎬 Multfilm
                            @break
                        @case('text')
                            📖 Matn
                            @break
                        @case('file')
                            📁 Yuklab olish
                            @break
                        @case('test')
                            📝 Test
                            @break
                        @case('image')
                            🖼️ Rasm
                            @break
                        @default
                            🎨 Aralash
                    @endswitch
                </span>
                @if($content->age_range)
                    <span class="card-badge">👶 {{ $content->age_range }}</span>
                @endif
            </div>
        </header>

        {{-- Cover image --}}
        @if($content->cover_image)
            <div style="margin-bottom: var(--space-lg); text-align: center; overflow: hidden;">
                <img src="{{ Storage::url($content->cover_image) }}" 
                     alt="{{ $content->title_ru }}"
                     style="max-width: 100%; height: auto; border-radius: var(--radius-md); box-shadow: var(--shadow-md); display: block; margin: 0 auto;">
            </div>
        @endif

        {{-- Audio player --}}
        @if($content->audio_url)
            <div class="audio-player">
                <p style="font-weight: 700; margin-bottom: var(--space-sm);">🎧 Tinglash / Слушать:</p>
                <audio controls style="width: 100%;">
                    <source src="{{ $content->audio_url }}" type="audio/mpeg">
                    Sizning brauzeringiz audio formatini qo'llab-quvvatlamaydi.
                </audio>
            </div>
        @endif

        {{-- Video player --}}
        @if($content->video_url)
            <div class="video-player">
                @php
                    // YouTube URL ni embed formatiga o'girish
                    $videoUrl = $content->video_url;
                    if (str_contains($videoUrl, 'youtube.com/watch')) {
                        preg_match('/v=([^&]+)/', $videoUrl, $matches);
                        $videoId = $matches[1] ?? '';
                        $videoUrl = "https://www.youtube.com/embed/{$videoId}";
                    } elseif (str_contains($videoUrl, 'youtu.be/')) {
                        $videoId = basename($videoUrl);
                        $videoUrl = "https://www.youtube.com/embed/{$videoId}";
                    }
                @endphp
                <iframe src="{{ $videoUrl }}" 
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                </iframe>
            </div>
        @endif

        {{-- Text body --}}
        @if($content->body_ru)
            <div class="content-body">
                {!! $content->body_ru !!}
            </div>
            
            @if($content->body_uz)
                <hr style="margin: var(--space-xl) 0; border: none; border-top: 2px solid var(--color-bg-section);">
                <p style="font-weight: 700; margin-bottom: var(--space-sm); color: var(--color-primary);">
                    🇺🇿 O'zbek tilida:
                </p>
                <div class="content-body">
                    {!! $content->body_uz !!}
                </div>
            @endif
        @endif

        {{-- File download --}}
        @if($content->file_url)
            <div style="margin: var(--space-lg) 0; padding: var(--space-lg); background: var(--color-bg-section); border-radius: var(--radius-md);">
                <p style="font-weight: 700; margin-bottom: var(--space-sm);">📁 Yuklab olish / Скачать:</p>
                <a href="{{ Storage::url($content->file_url) }}" 
                   class="btn btn-primary" 
                   download
                   target="_blank">
                    ⬇️ Faylni yuklab olish
                </a>
            </div>
        @endif

        {{-- Test button --}}
        @if($content->type === 'test' && $content->test)
            <div style="margin: var(--space-lg) 0; padding: var(--space-lg); background: linear-gradient(135deg, var(--color-bg-section) 0%, var(--color-accent-light) 100%); border-radius: var(--radius-md); text-align: center;">
                <p style="font-size: 1.25rem; font-weight: 700; margin-bottom: var(--space-sm);">
                    📝 {{ $content->test->title }}
                </p>
                @if($content->test->description)
                    <p style="margin-bottom: var(--space-md); color: var(--color-text-light);">
                        {{ $content->test->description }}
                    </p>
                @endif
                <p style="margin-bottom: var(--space-md);">
                    <span class="card-badge">❓ {{ $content->test->questions_count }} savol</span>
                    @if($content->test->time_limit)
                        <span class="card-badge">⏱️ {{ $content->test->time_limit }} daqiqa</span>
                    @endif
                </p>
                <a href="{{ locale_url('test.show', ['id' => $content->test->id]) }}" class="btn btn-accent">
                    🚀 {{ current_locale() === 'uz' ? 'Testni boshlash' : 'Начать тест' }}
                </a>
            </div>
        @endif

        {{-- Navigation --}}
        <div class="nav-buttons">
            @if($prevContent)
                <a href="{{ locale_url('content.show', ['id' => $prevContent->id]) }}" class="btn btn-outline">
                    ← {{ Str::limit(current_locale() === 'uz' && $prevContent->title_uz ? $prevContent->title_uz : $prevContent->title_ru, 20) }}
                </a>
            @else
                <span></span>
            @endif
            
            @if($nextContent)
                <a href="{{ locale_url('content.show', ['id' => $nextContent->id]) }}" class="btn btn-primary">
                    {{ Str::limit(current_locale() === 'uz' && $nextContent->title_uz ? $nextContent->title_uz : $nextContent->title_ru, 20) }} →
                </a>
            @endif
        </div>
    </article>
@endsection

