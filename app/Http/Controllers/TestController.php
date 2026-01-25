<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

/**
 * TestController - Testlar uchun controller
 */
class TestController extends Controller
{
    /**
     * Test sahifasini ko'rsatish
     */
    public function show(string $locale, int $id): View
    {
        $test = Test::query()
            ->with(['content', 'questions.options'])
            ->where('is_active', true)
            ->findOrFail($id);

        return view('test.show', compact('test'));
    }

    /**
     * Test natijasini saqlash (AJAX)
     */
    public function submit(Request $request, string $locale, int $id): JsonResponse
    {
        $test = Test::with('questions.options')
            ->where('is_active', true)
            ->findOrFail($id);

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer',
            'started_at' => 'nullable|date',
        ]);

        $answers = $validated['answers'];
        $totalQuestions = $test->questions->count();
        $correctAnswers = 0;

        // Javoblarni tekshirish
        foreach ($test->questions as $question) {
            $selectedOptionId = $answers[$question->id] ?? null;
            
            if ($selectedOptionId) {
                $correctOption = $question->options->where('is_correct', true)->first();
                if ($correctOption && $correctOption->id == $selectedOptionId) {
                $correctAnswers++;
            }
            }
        }

        // Ballni hisoblash (100 ballik tizim)
        $score = $totalQuestions > 0 
            ? round(($correctAnswers / $totalQuestions) * 100) 
            : 0;

        // Natijani saqlash
        $attempt = TestAttempt::create([
            'test_id' => $test->id,
            'user_id' => auth()->id(),
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'started_at' => $validated['started_at'] ?? now(),
            'finished_at' => now(),
        ]);

        return response()->json([
            'success' => true,
                'score' => $score,
            'correct_answers' => $correctAnswers,
                'total_questions' => $totalQuestions,
            'attempt_id' => $attempt->id,
        ]);
    }

    /**
     * Test natijasini ko'rsatish
     */
    public function result(string $locale, int $id, int $attemptId): View
    {
        $test = Test::with(['content', 'questions.options'])
            ->where('is_active', true)
            ->findOrFail($id);

        $attempt = TestAttempt::where('test_id', $id)
            ->findOrFail($attemptId);

        return view('test.result', compact('test', 'attempt'));
    }
}
