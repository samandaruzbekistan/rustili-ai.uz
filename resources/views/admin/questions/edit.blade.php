@extends('layouts.kids')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Savolni tahrirlash ({{ $topic->title_ru }})</h2>
        <a href="{{ route('admin.topics.questions.index', $topic) }}" class="text-decoration-none">← Orqaga</a>
    </div>

    <div class="card card-kid p-4">
        <form method="POST" action="{{ route('admin.topics.questions.update', [$topic, $question]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Savol matni (ruscha)</label>
                <textarea name="question_text_ru" class="form-control" rows="3" required>{{ old('question_text_ru', $question->question_text_ru) }}</textarea>
            </div>
            <div class="row g-3">
                @foreach(['a','b','c','d'] as $option)
                    <div class="col-md-6">
                        <label class="form-label">Variant {{ strtoupper($option) }}</label>
                        <input type="text" name="option_{{ $option }}" class="form-control" required value="{{ old('option_'.$option, $question->{'option_'.$option}) }}">
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                <label class="form-label">To'g'ri variant</label>
                <select name="correct_option" class="form-select" required>
                    @foreach(['a','b','c','d'] as $option)
                        <option value="{{ $option }}" {{ old('correct_option', $question->correct_option) === $option ? 'selected' : '' }}>{{ strtoupper($option) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 text-end">
                <button class="btn btn-cta">Yangilash</button>
            </div>
        </form>
    </div>
@endsection
