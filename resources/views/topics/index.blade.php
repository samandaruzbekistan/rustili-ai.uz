@extends('layouts.kids')

@section('content')
    <div class="mb-4 text-center">
        <h1 class="fw-bold">Mavzular</h1>
        <p class="text-secondary">Quyidagi rangli kartochkalardan birini tanlang.</p>
    </div>

    <div class="row g-3">
        @forelse($topics as $topic)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card card-kid h-100 p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="badge-emoji">{{ $topic->emoji ?? '📖' }}</span>
                        <span class="badge bg-info-subtle text-info fw-semibold">#{{ $topic->order }}</span>
                    </div>
                    <h6 class="mt-3 fw-bold">{{ $topic->title_ru }}</h6>
                    <p class="text-secondary mb-3">{{ $topic->title_uz }}</p>
                    <a href="{{ route('topics.show', $topic->slug) }}" class="btn btn-sm btn-cta w-100">Kirish</a>
                </div>
            </div>
        @empty
            <p>Mavzular topilmadi.</p>
        @endforelse
    </div>
@endsection
