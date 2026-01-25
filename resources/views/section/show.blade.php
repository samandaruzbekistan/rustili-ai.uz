@extends('layouts.kids')

@section('title', (current_locale() === 'uz' && $section->title_uz ? $section->title_uz : $section->title_ru) . ' - ' . (current_locale() === 'uz' && $chapter->title_uz ? $chapter->title_uz : $chapter->title_ru))

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ locale_url('home') }}">🏠 {{ current_locale() === 'uz' ? 'Bosh sahifa' : 'Главная' }}</a>
        <span class="breadcrumb-separator">›</span>
        <a href="{{ locale_url('chapter.show', ['slug' => $chapter->slug]) }}">{{ current_locale() === 'uz' && $chapter->title_uz ? $chapter->title_uz : $chapter->title_ru }}</a>
        <span class="breadcrumb-separator">›</span>
        <span>{{ current_locale() === 'uz' && $section->title_uz ? $section->title_uz : $section->title_ru }}</span>
    </nav>

    {{-- Banner --}}
    <div class="banner">
        @if($section->cover_image)
            <img src="{{ Storage::url($section->cover_image) }}" alt="{{ $section->title_ru }}">
        @elseif($chapter->cover_image)
            <img src="{{ Storage::url($chapter->cover_image) }}" alt="{{ $chapter->title_ru }}">
        @endif
        <div class="banner-overlay">
            <h1 class="banner-title">{{ $section->type_icon }} {{ current_locale() === 'uz' && $section->title_uz ? $section->title_uz : $section->title_ru }}</h1>
            @if(current_locale() === 'ru' && $section->title_uz)
                <p class="banner-subtitle">{{ $section->title_uz }}</p>
            @elseif(current_locale() === 'uz' && $section->title_ru)
                <p class="banner-subtitle">{{ $section->title_ru }}</p>
            @endif
        </div>
    </div>

    {{-- Description --}}
    @if($section->description)
        <section style="margin-bottom: var(--space-xl);">
            <div class="section-header">
                <h2 class="section-title">📝 {{ current_locale() === 'uz' ? 'Tavsif' : 'Описание' }}</h2>
            </div>
            <div class="content-body" style="background: var(--color-bg-section); padding: var(--space-lg); border-radius: var(--radius-md); line-height: 1.8; font-size: 1.1rem;">
                {!! $section->formatted_description !!}
            </div>
        </section>
    @endif

    {{-- Filter panel --}}
    <div class="filter-panel">
        <div style="display: flex; flex-wrap: wrap; gap: var(--space-lg);">
            {{-- Type filter --}}
            <div>
                <p class="filter-title">📁 {{ current_locale() === 'uz' ? 'Turi bo\'yicha' : 'По типу' }}:</p>
                <div class="filter-group">
                    <a href="{{ locale_url('section.show', ['chapterSlug' => $chapter->slug, 'sectionSlug' => $section->slug]) }}" 
                       class="filter-btn {{ !request('type') ? 'active' : '' }}">
                        {{ current_locale() === 'uz' ? 'Hammasi' : 'Все' }}
                    </a>
                    <a href="{{ locale_url('section.show', ['chapterSlug' => $chapter->slug, 'sectionSlug' => $section->slug]) }}?type=text" 
                       class="filter-btn {{ request('type') == 'text' ? 'active' : '' }}">
                        📖 {{ current_locale() === 'uz' ? 'Matn' : 'Текст' }}
                    </a>
                    <a href="{{ locale_url('section.show', ['chapterSlug' => $chapter->slug, 'sectionSlug' => $section->slug]) }}?type=audio" 
                       class="filter-btn {{ request('type') == 'audio' ? 'active' : '' }}">
                        🎧 Audio
                    </a>
                    <a href="{{ locale_url('section.show', ['chapterSlug' => $chapter->slug, 'sectionSlug' => $section->slug]) }}?type=video" 
                       class="filter-btn {{ request('type') == 'video' ? 'active' : '' }}">
                        🎬 Video
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Topishmoqlar (Riddles) --}}
    @if(isset($riddles) && $riddles->isNotEmpty())
    <section style="margin-top: var(--space-xl);">
        <div class="section-header">
            <h2 class="section-title">❓ {{ current_locale() === 'uz' ? 'Topishmoqlar' : 'Загадки' }}</h2>
        </div>
        
        <div class="riddles-list">
            @foreach($riddles as $riddle)
                <div class="riddle-card" data-riddle-id="{{ $riddle->id }}">
                    <div class="riddle-question">
                        <h3 class="riddle-title">
                            {{ $riddle->type_icon }} {{ current_locale() === 'uz' && $riddle->title_uz ? $riddle->title_uz : $riddle->title_ru }}
                        </h3>
                        <button type="button" class="btn btn-primary riddle-toggle-btn" onclick="toggleRiddleAnswer({{ $riddle->id }})">
                            <span class="btn-text-show">👁️ {{ current_locale() === 'uz' ? 'Javobni ko\'rish' : 'Показать ответ' }}</span>
                            <span class="btn-text-hide" style="display: none;">🙈 {{ current_locale() === 'uz' ? 'Javobni yashirish' : 'Скрыть ответ' }}</span>
                        </button>
                    </div>
                    <div class="riddle-answer" id="riddle-answer-{{ $riddle->id }}" style="display: none;">
                        <div class="riddle-answer-content">
                            <h4 style="font-weight: 700; margin-bottom: var(--space-sm); color: var(--color-primary);">
                                💡 {{ current_locale() === 'uz' ? 'Javob' : 'Ответ' }}:
                            </h4>
                            @if(current_locale() === 'ru')
                                {!! $riddle->body_ru ?? $riddle->body_uz !!}
                            @else
                                {!! $riddle->body_uz ?? $riddle->body_ru !!}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Contents grid --}}
    <section>
        <div class="section-header">
            <h2 class="section-title">📄 {{ current_locale() === 'uz' ? 'Materiallar' : 'Материалы' }} ({{ $contents->count() }})</h2>
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
                                    @case('riddle')
                                        {{ current_locale() === 'uz' ? 'Topishmoq' : 'Загадка' }}
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
                    <a href="{{ locale_url('section.show', ['chapterSlug' => $chapter->slug, 'sectionSlug' => $section->slug]) }}" class="btn btn-primary" style="margin-top: 1rem;">
                        🔄 {{ current_locale() === 'uz' ? 'Filtrni tozalash' : 'Очистить фильтр' }}
                    </a>
                </div>
            @endforelse
        </div>
    </section>

    @push('scripts')
    <script>
        function toggleRiddleAnswer(riddleId) {
            const answerDiv = document.getElementById('riddle-answer-' + riddleId);
            const btn = event.target.closest('.riddle-toggle-btn');
            const showText = btn.querySelector('.btn-text-show');
            const hideText = btn.querySelector('.btn-text-hide');
            
            if (answerDiv.style.display === 'none') {
                answerDiv.style.display = 'block';
                showText.style.display = 'none';
                hideText.style.display = 'inline';
            } else {
                answerDiv.style.display = 'none';
                showText.style.display = 'inline';
                hideText.style.display = 'none';
            }
        }
    </script>
    @endpush
@endsection
