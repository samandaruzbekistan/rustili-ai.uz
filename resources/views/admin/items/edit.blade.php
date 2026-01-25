@extends('layouts.kids')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">So'zni tahrirlash ({{ $topic->title_ru }})</h2>
        <a href="{{ route('admin.topics.items.index', $topic) }}" class="text-decoration-none">← Orqaga</a>
    </div>

    <div class="card card-kid p-4">
        <form method="POST" action="{{ route('admin.topics.items.update', [$topic, $item]) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Ruscha so'z</label>
                    <input type="text" name="word_ru" class="form-control" required value="{{ old('word_ru', $item->word_ru) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">O'zbekcha so'z</label>
                    <input type="text" name="word_uz" class="form-control" required value="{{ old('word_uz', $item->word_uz) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Rasm (path)</label>
                    <input type="text" name="image_path" class="form-control" value="{{ old('image_path', $item->image_path) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Audio (path)</label>
                    <input type="text" name="audio_path" class="form-control" value="{{ old('audio_path', $item->audio_path) }}">
                </div>
            </div>
            <div class="mt-3 text-end">
                <button class="btn btn-cta">Yangilash</button>
            </div>
        </form>
    </div>
@endsection
