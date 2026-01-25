@extends('layouts.kids')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold">Savollar: {{ $topic->title_ru }}</h2>
            <p class="text-secondary mb-0">Mavzu: {{ $topic->title_uz }}</p>
        </div>
        <a href="{{ route('admin.topics.questions.create', $topic) }}" class="btn btn-cta">Yangi savol</a>
    </div>

    <a href="{{ route('admin.topics.index') }}" class="text-decoration-none d-block mb-3">← Mavzular ro'yxati</a>

    <div class="card card-kid p-3">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Savol</th>
                    <th>To'g'ri variant</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    <tr>
                        <td>{{ $question->question_text_ru }}</td>
                        <td class="text-uppercase">{{ $question->correct_option }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.topics.questions.edit', [$topic, $question]) }}">Tahrirlash</a>
                            <form action="{{ route('admin.topics.questions.destroy', [$topic, $question]) }}" method="POST" onsubmit="return confirm('O\'chirilsinmi?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">O'chirish</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">Savollar hali yo'q.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
