<?php

namespace Database\Seeders;

use App\Models\LessonItem;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            ['title_ru' => 'Приветствие', 'title_uz' => 'Salomlashish', 'slug' => 'privetstvie', 'emoji' => '👋'],
            ['title_ru' => 'Цвета и оттенки', 'title_uz' => 'Ranglar', 'slug' => 'cveta-i-ottenki', 'emoji' => '🎨'],
            ['title_ru' => 'Части тела', 'title_uz' => 'Tana a’zolari', 'slug' => 'chasti-tela', 'emoji' => '🧠'],
            ['title_ru' => 'Моя семья', 'title_uz' => 'Oilam', 'slug' => 'moya-semya', 'emoji' => '👨‍👩‍👧‍👦'],
            ['title_ru' => 'Овощи', 'title_uz' => 'Sabzavotlar', 'slug' => 'ovoshi', 'emoji' => '🥕'],
            ['title_ru' => 'Фрукты', 'title_uz' => 'Mevalar', 'slug' => 'frukty', 'emoji' => '🍎'],
            ['title_ru' => 'Погода', 'title_uz' => 'Ob-havo', 'slug' => 'pogoda', 'emoji' => '⛅'],
            ['title_ru' => 'Времена года', 'title_uz' => 'Fasllar', 'slug' => 'vremena-goda', 'emoji' => '🌈'],
            ['title_ru' => 'Виды транспорта', 'title_uz' => 'Transport turlari', 'slug' => 'vidy-transporta', 'emoji' => '🚌'],
            ['title_ru' => 'Домашние животные', 'title_uz' => 'Uy hayvonlari', 'slug' => 'domashnie-zhivotnye', 'emoji' => '🐶'],
            ['title_ru' => 'Дикие животные', 'title_uz' => 'Yovvoyi hayvonlar', 'slug' => 'dikie-zhivotnye', 'emoji' => '🦁'],
        ];

        foreach ($topics as $index => $data) {
            $topic = Topic::create([
                'title_ru' => $data['title_ru'],
                'title_uz' => $data['title_uz'],
                'slug' => $data['slug'],
                'description' => $data['title_uz'] . ' mavzusi uchun quvnoq dars.',
                'emoji' => $data['emoji'],
                'order' => $index + 1,
            ]);

            if ($topic->slug === 'privetstvie') {
                LessonItem::create(['topic_id' => $topic->id, 'word_ru' => 'Привет', 'word_uz' => 'Salom']);
                LessonItem::create(['topic_id' => $topic->id, 'word_ru' => 'Пока', 'word_uz' => 'Xayr']);
                LessonItem::create(['topic_id' => $topic->id, 'word_ru' => 'Спасибо', 'word_uz' => 'Rahmat']);

                Question::create([
                    'topic_id' => $topic->id,
                    'question_text_ru' => 'Как по-русски сказать "salom"?',
                    'option_a' => 'Привет',
                    'option_b' => 'Пока',
                    'option_c' => 'Спасибо',
                    'option_d' => 'Пожалуйста',
                    'correct_option' => 'a',
                ]);

                Question::create([
                    'topic_id' => $topic->id,
                    'question_text_ru' => 'Выбери перевод слова "Спасибо".',
                    'option_a' => 'Iltimos',
                    'option_b' => 'Rahmat',
                    'option_c' => 'Salom',
                    'option_d' => 'Xayr',
                    'correct_option' => 'b',
                ]);
            }

            if ($topic->slug === 'cveta-i-ottenki') {
                LessonItem::create(['topic_id' => $topic->id, 'word_ru' => 'Красный', 'word_uz' => 'Qizil']);
                LessonItem::create(['topic_id' => $topic->id, 'word_ru' => 'Синий', 'word_uz' => 'Koʻk']);
                LessonItem::create(['topic_id' => $topic->id, 'word_ru' => 'Зелёный', 'word_uz' => 'Yashil']);

                Question::create([
                    'topic_id' => $topic->id,
                    'question_text_ru' => 'Какого цвета небо?',
                    'option_a' => 'Синий',
                    'option_b' => 'Красный',
                    'option_c' => 'Чёрный',
                    'option_d' => 'Белый',
                    'correct_option' => 'a',
                ]);
            }
        }
    }
}
