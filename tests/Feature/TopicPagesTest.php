<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_topics_preview(): void
    {
        $topic = Topic::factory()->create(['title_ru' => 'Приветствие', 'slug' => 'privetstvie']);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Rus tilini AI bilan qiziqarli o\'rganamiz!')
            ->assertSee($topic->title_ru);
    }

    public function test_topic_page_displays_lesson_items(): void
    {
        $topic = Topic::factory()->create(['slug' => 'colors']);
        $topic->lessonItems()->create(['word_ru' => 'Красный', 'word_uz' => 'Qizil']);

        $this->get(route('topics.show', $topic->slug))
            ->assertStatus(200)
            ->assertSee('Yangi so\'zlar')
            ->assertSee('Красный');
    }

    public function test_ai_test_submission_calculates_score(): void
    {
        $topic = Topic::factory()->create(['slug' => 'test-topic']);
        $questions = Question::factory()->count(2)->for($topic)->create([
            'correct_option' => 'a',
            'option_a' => 'to\'g\'ri',
            'option_b' => 'noto\'g\'ri',
            'option_c' => 'noto\'g\'ri',
            'option_d' => 'noto\'g\'ri',
        ]);

        $answers = [];
        foreach ($questions as $question) {
            $answers[$question->id] = 'a';
        }

        $this->post(route('topics.ai-test.submit', $topic->slug), [
            'answers' => $answers,
        ])->assertStatus(200)
          ->assertSee('Natija');
    }
}
