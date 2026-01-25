<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    public function definition(): array
    {
        $options = [
            $this->faker->word(),
            $this->faker->word(),
            $this->faker->word(),
            $this->faker->word(),
        ];

        return [
            'topic_id' => Topic::factory(),
            'question_text_ru' => $this->faker->sentence(),
            'option_a' => $options[0],
            'option_b' => $options[1],
            'option_c' => $options[2],
            'option_d' => $options[3],
            'correct_option' => 'a',
        ];
    }
}
