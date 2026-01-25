@extends('layouts.kids')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Mavzular (Admin)</h2>
        <a href="{{ route('admin.topics.create') }}" class="btn btn-cta">Yangi mavzu</a>
    </div>

    <div class="table-responsive card card-kid p-3">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Emoji</th>
                    <th>Ruscha</th>
                    <th>O'zbekcha</th>
                    <th>Slug</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>{{ $topic->order }}</td>
                        <td>{{ $topic->emoji }}</td>
                        <td>{{ $topic->title_ru }}</td>
                        <td>{{ $topic->title_uz }}</td>
                        <td>{{ $topic->slug }}</td>
                        <td class="d-flex gap-2 flex-wrap">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.topics.edit', $topic) }}">Tahrirlash</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.topics.items.index', $topic) }}">So'zlar</a>
                            <a class="btn btn-sm btn-outline-success" href="{{ route('admin.topics.questions.index', $topic) }}">Savollar</a>
                            <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" onsubmit="return confirm('O\'chirishni tasdiqlang?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">O'chirish</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
