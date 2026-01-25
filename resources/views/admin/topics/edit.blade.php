@extends('layouts.kids')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Mavzuni tahrirlash</h2>
        <a href="{{ route('admin.topics.index') }}" class="text-decoration-none">← Orqaga</a>
    </div>

    <div class="card card-kid p-4">
        <form method="POST" action="{{ route('admin.topics.update', $topic) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Ruscha nom</label>
                    <input type="text" name="title_ru" class="form-control" required value="{{ old('title_ru', $topic->title_ru) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">O'zbekcha nom</label>
                    <input type="text" name="title_uz" class="form-control" required value="{{ old('title_uz', $topic->title_uz) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" required value="{{ old('slug', $topic->slug) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Emoji</label>
                    <input type="text" name="emoji" class="form-control" value="{{ old('emoji', $topic->emoji) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tartib (order)</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $topic->order) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Tavsif</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $topic->description) }}</textarea>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button class="btn btn-cta">Yangilash</button>
            </div>
        </form>
    </div>
@endsection
