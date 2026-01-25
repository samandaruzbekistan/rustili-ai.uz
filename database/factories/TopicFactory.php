<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    public function definition(): array
    {
        $titleRu = $this->faker->words(2, true);

        return [
            'title_ru' => $titleRu,
            'title_uz' => $this->faker->words(2, true),
            'slug' => Str::slug($titleRu) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->sentence(),
            'emoji' => '🎈',
            'order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
