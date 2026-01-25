<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::orderBy('order')->get();

        return view('topics.index', compact('topics'));
    }

    public function show(string $slug)
    {
        $topic = Topic::where('slug', $slug)
            ->with(['lessonItems', 'questions'])
            ->firstOrFail();

        return view('topics.show', compact('topic'));
    }
}
