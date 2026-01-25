<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\LessonItem>
 */
class LessonItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'word_ru' => $this->faker->word(),
            'word_uz' => $this->faker->word(),
            'image_path' => null,
            'audio_path' => null,
        ];
    }
}
