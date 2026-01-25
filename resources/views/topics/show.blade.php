@extends('layouts.kids')

@section('content')
    <div class="card card-kid p-4 mb-4">
        <div class="d-flex align-items-center gap-3">
            <span class="badge-emoji display-6">{{ $topic->emoji ?? '📚' }}</span>
            <div>
                <h2 class="fw-bold mb-1">{{ $topic->title_ru }}</h2>
                <p class="mb-0 text-secondary">{{ $topic->title_uz }}</p>
            </div>
        </div>
        @if($topic->description)
            <p class="mt-3 mb-0 text-secondary">{{ $topic->description }}</p>
        @endif
    </div>

    <div class="mb-4">
        <h4 class="fw-bold">Yangi so'zlar</h4>
        <div class="row g-3">
            @forelse($topic->lessonItems as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-kid p-3 h-100 text-center">
                        <h6 class="fw-bold">{{ $item->word_ru }}</h6>
                        <p class="text-secondary mb-0">{{ $item->word_uz }}</p>
                        {{-- Keyinroq: audio tugma shu yerda bo'ladi --}}
                    </div>
                </div>
            @empty
                <p>Bu mavzu uchun so'zlar qo'shilmagan.</p>
            @endforelse
        </div>
    </div>

    <div class="mb-4">
        <h4 class="fw-bold">Mashq</h4>
        <div class="card card-kid p-3">
            <p class="mb-0">Kartochkalardan birini tanlab, o'qib ko'ring va tarjimasini ayting. Keyin AI testga o'ting.</p>
        </div>
    </div>

    <div class="card card-kid p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">AI test</h4>
                <p class="mb-0 text-secondary">Mavzuga doir savollarni ishlang, natijani darhol ko'ring.</p>
            </div>
            <a href="{{ route('topics.ai-test', $topic->slug) }}" class="btn btn-cta btn-lg px-4">AI testni boshlash</a>
        </div>
    </div>
@endsection
