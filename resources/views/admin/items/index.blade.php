@extends('layouts.kids')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold">So'zlar: {{ $topic->title_ru }}</h2>
            <p class="text-secondary mb-0">Mavzu: {{ $topic->title_uz }}</p>
        </div>
        <a href="{{ route('admin.topics.items.create', $topic) }}" class="btn btn-cta">Yangi so'z</a>
    </div>

    <a href="{{ route('admin.topics.index') }}" class="text-decoration-none d-block mb-3">← Mavzular ro'yxati</a>

    <div class="card card-kid p-3">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Ruscha</th>
                    <th>O'zbekcha</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->word_ru }}</td>
                        <td>{{ $item->word_uz }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.topics.items.edit', [$topic, $item]) }}">Tahrirlash</a>
                            <form action="{{ route('admin.topics.items.destroy', [$topic, $item]) }}" method="POST" onsubmit="return confirm('O\'chirilsinmi?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">O'chirish</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">So'zlar hali yo'q.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
