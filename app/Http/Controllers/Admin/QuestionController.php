<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Topic $topic)
    {
        $questions = $topic->questions()->latest()->get();

        return view('admin.questions.index', compact('topic', 'questions'));
    }

    public function create(Topic $topic)
    {
        return view('admin.questions.create', compact('topic'));
    }

    public function store(Request $request, Topic $topic)
    {
        $data = $request->validate([
            'question_text_ru' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $topic->questions()->create($data);

        return redirect()->route('admin.topics.questions.index', $topic)->with('status', 'Savol qo\'shildi.');
    }

    public function edit(Topic $topic, Question $question)
    {
        $this->abortIfDifferentTopic($topic, $question);

        return view('admin.questions.edit', compact('topic', 'question'));
    }

    public function update(Request $request, Topic $topic, Question $question)
    {
        $this->abortIfDifferentTopic($topic, $question);

        $data = $request->validate([
            'question_text_ru' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $question->update($data);

        return redirect()->route('admin.topics.questions.index', $topic)->with('status', 'Savol yangilandi.');
    }

    public function destroy(Topic $topic, Question $question)
    {
        $this->abortIfDifferentTopic($topic, $question);
        $question->delete();

        return redirect()->route('admin.topics.questions.index', $topic)->with('status', 'Savol o\'chirildi.');
    }

    private function abortIfDifferentTopic(Topic $topic, Question $question): void
    {
        if ($question->topic_id !== $topic->id) {
            abort(404);
        }
    }
}
