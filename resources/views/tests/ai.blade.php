@extends('layouts.kids')

@section('content')
    <div class="mb-4">
        <a href="{{ route('topics.show', $topic->slug) }}" class="text-decoration-none">&larr; Orqaga</a>
    </div>

    <div class="card card-kid p-4 mb-4">
        <div class="d-flex align-items-center gap-3">
            <span class="badge-emoji display-6">{{ $topic->emoji ?? '🎯' }}</span>
            <div>
                <h2 class="fw-bold mb-1">{{ $topic->title_ru }}</h2>
                <p class="mb-0 text-secondary">{{ $topic->title_uz }} — AI test</p>
            </div>
        </div>
    </div>

    @if($result)
        <div class="alert alert-success">
            <h5 class="fw-bold mb-1">Natija: {{ $result['score'] }}%</h5>
            <p class="mb-0">To'g'ri javoblar: {{ $result['correct_answers'] }}/{{ $result['total_questions'] }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Javoblarni belgilang.
        </div>
    @endif

    <form method="POST" action="{{ route('topics.ai-test.submit', $topic->slug) }}">
        @csrf
        <div class="row g-3">
            @foreach($questions as $index => $question)
                @php
                    $selected = $result['details'][$index]['user_answer'] ?? old("answers.{$question->id}");
                @endphp
                <div class="col-md-6">
                    <div class="card card-kid p-3 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-warning text-dark">Savol {{ $loop->iteration }}</span>
                            <span class="fw-bold text-success">{{ $topic->emoji ?? '⭐' }}</span>
                        </div>
                        <p class="fw-semibold">{{ $question->question_text_ru }}</p>
                        @foreach(['a','b','c','d'] as $option)
                            @php $field = "option_{$option}"; @endphp
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}{{ $option }}" value="{{ $option }}" {{ $selected === $option ? 'checked' : '' }}>
                                <label class="form-check-label" for="q{{ $question->id }}{{ $option }}">
                                    {{ strtoupper($option) }}) {{ $question->$field }}
                                </label>
                            </div>
                        @endforeach
                        @if($result)
                            <div class="mt-2">
                                @php $isCorrect = $result['details'][$index]['is_correct'] ?? false; @endphp
                                <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
                                    {{ $isCorrect ? 'To\'g\'ri' : 'Noto\'g\'ri' }}
                                </span>
                                @unless($isCorrect)
                                    <small class="d-block text-secondary">
                                        To'g'ri javob: {{ strtoupper($question->correct_option) }}) {{ $question->{'option_'.$question->correct_option} }}
                                    </small>
                                @endunless
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-end">
            <button class="btn btn-cta btn-lg px-4">Natijani ko'rish</button>
        </div>
    </form>
@endsection
