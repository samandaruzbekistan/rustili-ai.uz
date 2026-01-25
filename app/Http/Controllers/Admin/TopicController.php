<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::orderBy('order')->get();

        return view('admin.topics.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.topics.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_ru' => 'required|string|max:255',
            'title_uz' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:topics,slug',
            'description' => 'nullable|string',
            'emoji' => 'nullable|string|max:10',
            'order' => 'nullable|integer',
        ]);

        Topic::create($data);

        return redirect()->route('admin.topics.index')->with('status', 'Mavzu yaratildi.');
    }

    public function edit(Topic $topic)
    {
        return view('admin.topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        $data = $request->validate([
            'title_ru' => 'required|string|max:255',
            'title_uz' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('topics')->ignore($topic->id)],
            'description' => 'nullable|string',
            'emoji' => 'nullable|string|max:10',
            'order' => 'nullable|integer',
        ]);

        $topic->update($data);

        return redirect()->route('admin.topics.index')->with('status', 'Mavzu yangilandi.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()->route('admin.topics.index')->with('status', 'Mavzu o\'chirildi.');
    }
}
