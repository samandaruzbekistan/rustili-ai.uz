@extends('layouts.kids')

@section('title', $test->title . ' - Test')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">🏠 Bosh sahifa</a>
        <span class="breadcrumb-separator">›</span>
        @if($test->content)
            <a href="{{ route('content.show', $test->content->id) }}">{{ $test->content->title_ru }}</a>
            <span class="breadcrumb-separator">›</span>
        @endif
        <span>{{ $test->title }}</span>
    </nav>

    {{-- Test container --}}
    <div class="content-detail" id="test-container">
        {{-- Header --}}
        <header class="content-header">
            <h1 class="content-title">📝 {{ $test->title }}</h1>
            @if($test->description)
                <p style="color: var(--color-text-light); margin-bottom: var(--space-sm);">
                    {{ $test->description }}
                </p>
            @endif
            <div class="content-meta">
                <span class="card-badge">❓ {{ $test->questions->count() }} savol</span>
                @if($test->time_limit)
                    <span class="card-badge" id="timer">⏱️ {{ $test->time_limit }}:00</span>
                @endif
            </div>
        </header>

        {{-- Test form --}}
        <form id="test-form">
            @csrf
            <input type="hidden" name="started_at" value="{{ now()->toIso8601String() }}">
            
            @foreach($test->questions as $index => $question)
                <div class="question-card" style="margin-bottom: var(--space-lg); padding: var(--space-lg); background: var(--color-bg-section); border-radius: var(--radius-md);">
                    <p style="font-weight: 700; font-size: 1.1rem; margin-bottom: var(--space-md);">
                        <span style="color: var(--color-primary);">{{ $index + 1 }}.</span> 
                        {{ $question->question_text }}
                    </p>
                    
                    @if($question->image)
                        <div style="margin-bottom: var(--space-md);">
                            <img src="{{ Storage::url($question->image) }}" 
                                 alt="Savol rasmi" 
                                 style="max-width: 100%; border-radius: var(--radius-sm);">
                        </div>
                    @endif
                    
                    <div class="options-list" style="display: flex; flex-direction: column; gap: var(--space-xs);">
                        @foreach($question->options as $option)
                            <label class="option-label" style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-sm); background: var(--color-bg-card); border-radius: var(--radius-sm); cursor: pointer; border: 2px solid transparent; transition: all 0.2s;">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $option->id }}"
                                       required
                                       style="width: 20px; height: 20px; accent-color: var(--color-primary);">
                                <span>{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Submit button --}}
            <div style="text-align: center; margin-top: var(--space-xl);">
                <button type="submit" class="btn btn-accent" style="font-size: 1.25rem; padding: var(--space-md) var(--space-xl);">
                    ✅ Testni yakunlash
                </button>
            </div>
        </form>

        {{-- Result container (hidden by default) --}}
        <div id="result-container" style="display: none; text-align: center; padding: var(--space-xl);">
            <div style="font-size: 5rem; margin-bottom: var(--space-md);" id="result-emoji">🎉</div>
            <h2 style="font-size: 2rem; margin-bottom: var(--space-sm);">Natija / Результат</h2>
            <p style="font-size: 3rem; font-weight: 700; color: var(--color-primary); margin-bottom: var(--space-md);">
                <span id="result-score">0</span>%
            </p>
            <p style="font-size: 1.25rem; color: var(--color-text-light); margin-bottom: var(--space-lg);">
                To'g'ri javoblar: <strong id="result-correct">0</strong> / <span id="result-total">0</span>
            </p>
            <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
                <button onclick="location.reload()" class="btn btn-primary">
                    🔄 Qayta urinish
                </button>
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
    </div>
@endsection

@push('styles')
<style>
    .option-label:hover {
        border-color: var(--color-primary) !important;
        background: #f0fff0 !important;
    }
    
    .option-label:has(input:checked) {
        border-color: var(--color-primary) !important;
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%) !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('test-form');
    const resultContainer = document.getElementById('result-container');
    const timerElement = document.getElementById('timer');
    
    // Timer (agar mavjud bo'lsa)
    @if($test->time_limit)
    let timeLeft = {{ $test->time_limit }} * 60; // daqiqalarni soniyalarga o'girish
    
    const timerInterval = setInterval(function() {
        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `⏱️ ${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            form.dispatchEvent(new Event('submit'));
        }
        
        // Oxirgi 60 soniyada qizil rang
        if (timeLeft <= 60) {
            timerElement.style.background = '#ffebee';
            timerElement.style.color = '#c62828';
        }
    }, 1000);
    @endif
    
    // Form submit
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        @if($test->time_limit)
        clearInterval(timerInterval);
        @endif
        
        const formData = new FormData(form);
        const answers = {};
        
        for (const [key, value] of formData.entries()) {
            const match = key.match(/answers\[(\d+)\]/);
            if (match) {
                answers[match[1]] = parseInt(value);
            }
        }
        
        try {
            const response = await fetch('{{ route("test.submit", $test->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    answers: answers,
                    started_at: formData.get('started_at'),
                }),
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Formni yashirish va natijani ko'rsatish
                form.style.display = 'none';
                resultContainer.style.display = 'block';
                
                // Natijalarni ko'rsatish
                document.getElementById('result-score').textContent = result.score;
                document.getElementById('result-correct').textContent = result.correct_answers;
                document.getElementById('result-total').textContent = result.total_questions;
                
                // Emoji tanlash
                const emoji = result.score >= 80 ? '🎉' : 
                             result.score >= 60 ? '👍' : 
                             result.score >= 40 ? '🤔' : '😅';
                document.getElementById('result-emoji').textContent = emoji;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.');
        }
    });
});
</script>
@endpush

