<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonItem;
use App\Models\Topic;
use Illuminate\Http\Request;

class LessonItemController extends Controller
{
    public function index(Topic $topic)
    {
        $items = $topic->lessonItems()->latest()->get();

        return view('admin.items.index', compact('topic', 'items'));
    }

    public function create(Topic $topic)
    {
        return view('admin.items.create', compact('topic'));
    }

    public function store(Request $request, Topic $topic)
    {
        $data = $request->validate([
            'word_ru' => 'required|string|max:255',
            'word_uz' => 'required|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'audio_path' => 'nullable|string|max:255',
        ]);

        $topic->lessonItems()->create($data);

        return redirect()->route('admin.topics.items.index', $topic)->with('status', 'So\'z qo\'shildi.');
    }

    public function edit(Topic $topic, LessonItem $item)
    {
        $this->abortIfDifferentTopic($topic, $item);

        return view('admin.items.edit', compact('topic', 'item'));
    }

    public function update(Request $request, Topic $topic, LessonItem $item)
    {
        $this->abortIfDifferentTopic($topic, $item);

        $data = $request->validate([
            'word_ru' => 'required|string|max:255',
            'word_uz' => 'required|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'audio_path' => 'nullable|string|max:255',
        ]);

        $item->update($data);

        return redirect()->route('admin.topics.items.index', $topic)->with('status', 'So\'z yangilandi.');
    }

    public function destroy(Topic $topic, LessonItem $item)
    {
        $this->abortIfDifferentTopic($topic, $item);
        $item->delete();

        return redirect()->route('admin.topics.items.index', $topic)->with('status', 'So\'z o\'chirildi.');
    }

    private function abortIfDifferentTopic(Topic $topic, LessonItem $item): void
    {
        if ($item->topic_id !== $topic->id) {
            abort(404);
        }
    }
}
