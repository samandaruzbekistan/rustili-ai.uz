<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Section;
use App\Models\Content;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestOption;
use Illuminate\Database\Seeder;

/**
 * ChapterSeeder - Boblar, bo'limlar va materiallar uchun seeder
 * deti-online.ru uslubidagi namuna ma'lumotlar
 */
class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================
        // 1-BOB: O'qish ko'nikmalarini rivojlantirish
        // =====================================
        $chapter1 = Chapter::create([
            'title_ru' => 'Учёба и развитие навыков чтения',
            'title_uz' => 'O\'qish ko\'nikmalarini mavzular yordamida rivojlantirish',
            'slug' => 'ucheba-i-razvitie-navykov-chteniya',
            'description' => 'Bu bo\'limda bolalar o\'qish va yozish ko\'nikmalarini rivojlantirish uchun turli materiallar to\'plangan.',
            'icon' => '📖',
            'cover_image' => 'chapters/reading.jpg',
            'default_content_type' => 'text',
            'order' => 1,
            'is_active' => true,
        ]);

        // 1-bob bo'limlari
        $sections1 = [
            [
                'title_ru' => 'Развитие навыков чтения',
                'title_uz' => 'O\'qish ko\'nikmalarini rivojlantirish',
                'slug' => 'razvitie-navykov-chteniya',
                'section_type' => 'text',
                'description' => 'Bolalar uchun o\'qish mashqlari va metodlari',
                'cover_image' => 'sections/reading-skills.jpg',
                'order' => 1,
            ],
            [
                'title_ru' => 'Развитие навыков письма',
                'title_uz' => 'Yozish ko\'nikmalarini rivojlantirish',
                'slug' => 'razvitie-navykov-pisma',
                'section_type' => 'text',
                'description' => 'Yozish mashqlari va chiroyli yozuv',
                'cover_image' => 'sections/writing-skills.jpg',
                'order' => 2,
            ],
            [
                'title_ru' => 'Сказки-рассказы',
                'title_uz' => 'Ertaklar-hikoyalar',
                'slug' => 'skazki-rasskazy',
                'section_type' => 'text',
                'description' => 'Bolalar uchun qiziqarli ertaklar va hikoyalar',
                'cover_image' => 'sections/fairy-tales.jpg',
                'order' => 3,
            ],
            [
                'title_ru' => 'Аудиосказки',
                'title_uz' => 'Audio ertaklar',
                'slug' => 'audioskazki',
                'section_type' => 'audio',
                'description' => 'Tinglash uchun ertaklar',
                'cover_image' => 'sections/audio-tales.jpg',
                'order' => 4,
            ],
            [
                'title_ru' => 'Загадки',
                'title_uz' => 'Topishmoqlar',
                'slug' => 'zagadki',
                'section_type' => 'text',
                'description' => 'Mantiqiy fikrlash uchun topishmoqlar',
                'cover_image' => 'sections/riddles.jpg',
                'order' => 5,
            ],
            [
                'title_ru' => 'Стихи',
                'title_uz' => 'She\'rlar',
                'slug' => 'stihi',
                'section_type' => 'text',
                'description' => 'Bolalar uchun she\'rlar',
                'cover_image' => 'sections/poems.jpg',
                'order' => 6,
            ],
            [
                'title_ru' => 'Мультфильмы',
                'title_uz' => 'Multfilmlar',
                'slug' => 'multfilmy',
                'section_type' => 'video',
                'description' => 'Ta\'limiy multfilmlar',
                'cover_image' => 'sections/cartoons.jpg',
                'order' => 7,
            ],
            [
                'title_ru' => 'Басни',
                'title_uz' => 'Masallar',
                'slug' => 'basni',
                'section_type' => 'text',
                'description' => 'Ibratli masallar',
                'cover_image' => 'sections/fables.jpg',
                'order' => 8,
            ],
            [
                'title_ru' => 'Творчество и рисование',
                'title_uz' => 'Ijod va rasm chizish',
                'slug' => 'tvorchestvo-i-risovanie',
                'section_type' => 'mixed',
                'description' => 'Rasm chizish bo\'yicha darslar',
                'cover_image' => 'sections/creativity.jpg',
                'order' => 9,
            ],
            [
                'title_ru' => 'Мысли автора',
                'title_uz' => 'Muallif fikrlari',
                'slug' => 'mysli-avtora',
                'section_type' => 'text',
                'description' => 'Mualliflarning donishmandona so\'zlari',
                'cover_image' => 'sections/thoughts.jpg',
                'order' => 10,
            ],
        ];

        foreach ($sections1 as $sectionData) {
            Section::create(array_merge($sectionData, [
                'chapter_id' => $chapter1->id,
                'is_active' => true,
            ]));
        }

        // =====================================
        // 2-BOB: Matematika asoslari
        // =====================================
        $chapter2 = Chapter::create([
            'title_ru' => 'Математика для детей',
            'title_uz' => 'Bolalar uchun matematika',
            'slug' => 'matematika-dlya-detey',
            'description' => 'Boshlang\'ich sinf o\'quvchilari uchun matematika darslari va mashqlar.',
            'icon' => '🔢',
            'cover_image' => 'chapters/math.jpg',
            'default_content_type' => 'mixed',
            'order' => 2,
            'is_active' => true,
        ]);

        // 2-bob bo'limlari
        $sections2 = [
            [
                'title_ru' => 'Счёт до 10',
                'title_uz' => '10 gacha sanash',
                'slug' => 'schyot-do-10',
                'section_type' => 'text',
                'description' => 'Raqamlar bilan tanishuv',
                'order' => 1,
            ],
            [
                'title_ru' => 'Сложение и вычитание',
                'title_uz' => 'Qo\'shish va ayirish',
                'slug' => 'slozhenie-i-vychitanie',
                'section_type' => 'mixed',
                'description' => 'Arifmetik amallar',
                'order' => 2,
            ],
            [
                'title_ru' => 'Математические игры',
                'title_uz' => 'Matematik o\'yinlar',
                'slug' => 'matematicheskie-igry',
                'section_type' => 'test',
                'description' => 'O\'yin orqali o\'rganish',
                'order' => 3,
            ],
        ];

        foreach ($sections2 as $sectionData) {
            Section::create(array_merge($sectionData, [
                'chapter_id' => $chapter2->id,
                'is_active' => true,
            ]));
        }

        // =====================================
        // 3-BOB: Yosh toifalari
        // =====================================
        $chapter3 = Chapter::create([
            'title_ru' => 'Возрастные категории',
            'title_uz' => 'Yosh toifalari bo\'yicha ertaklar',
            'slug' => 'vozrastnye-kategorii',
            'description' => 'Turli yoshdagi bolalar uchun ertaklar va hikoyalar.',
            'icon' => '👶',
            'cover_image' => 'chapters/age-categories.jpg',
            'default_content_type' => 'text',
            'order' => 3,
            'is_active' => true,
        ]);

        // 3-bob bo'limlari
        $sections3 = [
            [
                'title_ru' => 'Сказки для детей с 3 до 10 лет',
                'title_uz' => '3 dan 10 yoshgacha bolalar uchun ertaklar',
                'slug' => 'skazki-3-10-let',
                'section_type' => 'generic',
                'description' => 'Barcha yoshlar uchun mos ertaklar',
                'order' => 1,
            ],
            [
                'title_ru' => 'Узбекские народные сказки',
                'title_uz' => 'O\'zbek xalq ertaklari',
                'slug' => 'uzbekskie-narodnye-skazki',
                'section_type' => 'text',
                'description' => 'O\'zbek xalqining boy madaniy merosi',
                'order' => 2,
            ],
            [
                'title_ru' => 'Сказки народов мира',
                'title_uz' => 'Dunyo xalqlari ertaklari',
                'slug' => 'skazki-narodov-mira',
                'section_type' => 'text',
                'description' => 'Turli mamlakatlardan ertaklar',
                'order' => 3,
            ],
            [
                'title_ru' => 'Сказки братьев Гримм',
                'title_uz' => 'Grimm aka-ukalar ertaklari',
                'slug' => 'skazki-bratev-grimm',
                'section_type' => 'text',
                'description' => 'Mashhur nemis ertaklari',
                'order' => 4,
            ],
            [
                'title_ru' => 'Сказки Андерсена',
                'title_uz' => 'Andersen ertaklari',
                'slug' => 'skazki-andersena',
                'section_type' => 'text',
                'description' => 'Gans Xristian Andersen asarlari',
                'order' => 5,
            ],
            [
                'title_ru' => 'Сказки Шарля Перро',
                'title_uz' => 'Sharl Perro ertaklari',
                'slug' => 'skazki-sharlya-perro',
                'section_type' => 'text',
                'description' => 'Fransuz ertakchi asarlari',
                'order' => 6,
            ],
            [
                'title_ru' => 'Книги, рассказы',
                'title_uz' => 'Kitoblar, hikoyalar',
                'slug' => 'knigi-rasskazy',
                'section_type' => 'text',
                'description' => 'Turli kitoblar va qisqa hikoyalar',
                'order' => 7,
            ],
        ];

        foreach ($sections3 as $sectionData) {
            Section::create(array_merge($sectionData, [
                'chapter_id' => $chapter3->id,
                'is_active' => true,
            ]));
        }

        // =====================================
        // 4-BOB: Bo'limsiz bob (direct contents)
        // =====================================
        $chapter4 = Chapter::create([
            'title_ru' => 'Развивающие игры',
            'title_uz' => 'Rivojlantiruvchi o\'yinlar',
            'slug' => 'razvivayushchie-igry',
            'description' => 'Bolalar uchun mantiqiy o\'yinlar va bosh qotirmalar.',
            'icon' => '🎮',
            'cover_image' => 'chapters/games.jpg',
            'default_content_type' => 'test',
            'order' => 4,
            'is_active' => true,
        ]);

        // =====================================
        // NAMUNA MATERIALLAR (Contents)
        // =====================================
        
        // 1-bob, Ertaklar bo'limi uchun namuna ertaklar
        $ertaklarSection = Section::where('slug', 'skazki-rasskazy')->first();
        
        $content1 = Content::create([
            'chapter_id' => $chapter1->id,
            'section_id' => $ertaklarSection->id,
            'title_ru' => 'Курочка Ряба',
            'title_uz' => 'Tuxum soladigan tovuq',
            'type' => 'text',
            'body_ru' => '<p>Жили-были дед да баба. И была у них курочка Ряба.</p>
                <p>Снесла курочка яичко, да не простое — золотое.</p>
                <p>Дед бил, бил — не разбил. Баба била, била — не разбила.</p>
                <p>Мышка бежала, хвостиком махнула, яичко упало и разбилось.</p>
                <p>Плачет дед, плачет баба.</p>
                <p>А курочка говорит: «Не плачь, дед, не плачь, баба: снесу вам яичко не золотое — простое!»</p>',
            'body_uz' => '<p>Bir bor ekan, bir yo\'q ekan, bir chol bilan kampir bo\'lgan ekan. Ularning Ryaba ismli tovug\'i bor ekan.</p>
                <p>Tovuq tuxum tashlab, u oddiy emas - oltin ekan.</p>
                <p>Chol urdi, urdi - sindirolmadi. Kampir urdi, urdi - sindirolmadi.</p>
                <p>Sichqon yugurib o\'tdi, dumi bilan silkitdi, tuxum tushib sindi.</p>
                <p>Chol yig\'laydi, kampir yig\'laydi.</p>
                <p>Tovuq esa dedi: "Yig\'lama, chol, yig\'lama, kampir: men sizlarga oltin emas - oddiy tuxum qo\'yaman!"</p>',
            'age_from' => 3,
            'age_to' => 6,
            'order' => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        Content::create([
            'chapter_id' => $chapter1->id,
            'section_id' => $ertaklarSection->id,
            'title_ru' => 'Колобок',
            'title_uz' => 'Kolobok',
            'type' => 'text',
            'body_ru' => '<p>Жили-были старик со старухой. Вот и просит старик:</p>
                <p>— Испеки мне, старуха, колобок.</p>
                <p>— Да из чего испечь-то? Муки нет.</p>
                <p>— Эх, старуха! По амбару помети, по сусекам поскреби — вот и наберётся.</p>
                <p>Старуха так и сделала: намела, наскребла горсти две муки, замесила тесто на сметане, скатала колобок, изжарила его в масле и положила на окно остывать.</p>
                <p>Надоело колобку лежать: он и покатился с окна на лавку, с лавки на пол — да к двери, прыг через порог в сени, из сеней на крыльцо, с крыльца на двор, а там и за ворота, дальше и дальше...</p>',
            'body_uz' => '<p>Bir bor ekan, bir yo\'q ekan, bir chol bilan kampir yashar ekan. Chol so\'radi:</p>
                <p>— Menga kolobok pishirib ber, kampir.</p>
                <p>— Nimadan pishiray? Un yo\'q-ku.</p>
                <p>— Eh, kampir! Omborni supurib, qozonlarni qirib ko\'r - un yig\'ilib qoladi.</p>
                <p>Kampir shunday qildi: supurdi, qirdi - ikki hovuch un yig\'ildi, smetanada xamir qordi, kolobok yasab, yog\'da qovurdi va sovishi uchun derazaga qo\'ydi.</p>
                <p>Kolobokka yotish zerikarli bo\'ldi: u derazadan skameykaga, skameykadan yerga - eshikka qarab dumaladi, ostonadan sakrab hovliga, hovlidan ko\'chaga - va uzoqlashib ketdi...</p>',
            'age_from' => 3,
            'age_to' => 7,
            'order' => 2,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Audio ertak
        $audioSection = Section::where('slug', 'audioskazki')->first();
        
        Content::create([
            'chapter_id' => $chapter1->id,
            'section_id' => $audioSection->id,
            'title_ru' => 'Теремок (аудиосказка)',
            'title_uz' => 'Teremok (audio ertak)',
            'type' => 'audio',
            'audio_url' => 'https://example.com/audio/teremok.mp3',
            'body_ru' => '<p>Стоит в поле теремок-теремок, он не низок, не высок, не высок...</p>',
            'age_from' => 3,
            'age_to' => 6,
            'order' => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Video - Multfilm
        $videoSection = Section::where('slug', 'multfilmy')->first();
        
        Content::create([
            'chapter_id' => $chapter1->id,
            'section_id' => $videoSection->id,
            'title_ru' => 'Маша и Медведь',
            'title_uz' => 'Masha va Ayiq',
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=KYniUCGPGLs',
            'body_ru' => '<p>Популярный мультфильм о девочке Маше и её друге Медведе.</p>',
            'age_from' => 3,
            'age_to' => 10,
            'order' => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Topishmoqlar
        $riddlesSection = Section::where('slug', 'zagadki')->first();
        
        Content::create([
            'chapter_id' => $chapter1->id,
            'section_id' => $riddlesSection->id,
            'title_ru' => 'Загадки про животных',
            'title_uz' => 'Hayvonlar haqida topishmoqlar',
            'type' => 'text',
            'body_ru' => '<h2>🐱 Загадки про кошку</h2>
                <p>Мохнатенька, усатенька,<br>Молочко пьёт, песенки поёт.</p>
                <p><em>Ответ: Кошка</em></p>
                
                <h2>🐕 Загадки про собаку</h2>
                <p>С хозяином дружит,<br>Дом сторожит,<br>Живёт под крылечком,<br>А хвост колечком.</p>
                <p><em>Ответ: Собака</em></p>
                
                <h2>🐰 Загадки про зайца</h2>
                <p>Комочек пуха, длинное ухо,<br>Прыгает ловко, любит морковку.</p>
                <p><em>Ответ: Заяц</em></p>',
            'body_uz' => '<h2>🐱 Mushuk haqida topishmoq</h2>
                <p>Tukli, mo\'ylovli,<br>Sut ichadi, qo\'shiq aytadi.</p>
                <p><em>Javob: Mushuk</em></p>
                
                <h2>🐕 It haqida topishmoq</h2>
                <p>Xo\'jayin bilan do\'st,<br>Uyni qo\'riqlaydi,<br>Ayvon ostida yashaydi,<br>Dumi halqa.</p>
                <p><em>Javob: It</em></p>
                
                <h2>🐰 Quyon haqida topishmoq</h2>
                <p>Tuk to\'pi, uzun quloq,<br>Chaqqon sakraydi, sabzini yaxshi ko\'radi.</p>
                <p><em>Javob: Quyon</em></p>',
            'age_from' => 4,
            'age_to' => 8,
            'order' => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // =====================================
        // 4-BOB UCHUN TO'G'RIDAN-TO'G'RI MATERIALLAR
        // =====================================
        $testContent = Content::create([
            'chapter_id' => $chapter4->id,
            'section_id' => null, // Bo'limsiz
            'title_ru' => 'Тест: Животные',
            'title_uz' => 'Test: Hayvonlar',
            'type' => 'test',
            'body_ru' => '<p>Hayvonlar haqida bilimingizni sinab ko\'ring!</p>',
            'age_from' => 5,
            'age_to' => 8,
            'order' => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Test yaratish
        $test = Test::create([
            'content_id' => $testContent->id,
            'title' => 'Hayvonlar haqida test',
            'description' => 'Hayvonlar haqida bilimingizni sinab ko\'ring!',
            'time_limit' => 5,
            'attempts_allowed' => 3,
            'is_active' => true,
        ]);

        // Test savollari
        $question1 = TestQuestion::create([
            'test_id' => $test->id,
            'question_text' => 'Mushuk qanday ovoz chiqaradi?',
            'order' => 1,
        ]);

        TestOption::create(['question_id' => $question1->id, 'option_text' => 'Vov-vov', 'is_correct' => false, 'order' => 1]);
        TestOption::create(['question_id' => $question1->id, 'option_text' => 'Myau-myau', 'is_correct' => true, 'order' => 2]);
        TestOption::create(['question_id' => $question1->id, 'option_text' => 'Mu-mu', 'is_correct' => false, 'order' => 3]);
        TestOption::create(['question_id' => $question1->id, 'option_text' => 'Xo-xo', 'is_correct' => false, 'order' => 4]);

        $question2 = TestQuestion::create([
            'test_id' => $test->id,
            'question_text' => 'Qaysi hayvon sut beradi?',
            'order' => 2,
        ]);

        TestOption::create(['question_id' => $question2->id, 'option_text' => 'Tovuq', 'is_correct' => false, 'order' => 1]);
        TestOption::create(['question_id' => $question2->id, 'option_text' => 'Baliq', 'is_correct' => false, 'order' => 2]);
        TestOption::create(['question_id' => $question2->id, 'option_text' => 'Sigir', 'is_correct' => true, 'order' => 3]);
        TestOption::create(['question_id' => $question2->id, 'option_text' => 'Qush', 'is_correct' => false, 'order' => 4]);

        $question3 = TestQuestion::create([
            'test_id' => $test->id,
            'question_text' => 'Fil qayerda yashaydi?',
            'order' => 3,
        ]);

        TestOption::create(['question_id' => $question3->id, 'option_text' => 'Shimoliy qutbda', 'is_correct' => false, 'order' => 1]);
        TestOption::create(['question_id' => $question3->id, 'option_text' => 'Afrika va Osiyoda', 'is_correct' => true, 'order' => 2]);
        TestOption::create(['question_id' => $question3->id, 'option_text' => 'Avstraliyada', 'is_correct' => false, 'order' => 3]);
        TestOption::create(['question_id' => $question3->id, 'option_text' => 'Antarktidada', 'is_correct' => false, 'order' => 4]);

        // Yana bir material (bo'limsiz)
        Content::create([
            'chapter_id' => $chapter4->id,
            'section_id' => null,
            'title_ru' => 'Головоломка: Найди отличия',
            'title_uz' => 'Bosh qotirma: Farqlarni top',
            'type' => 'image',
            'body_ru' => '<p>Ikki rasm orasidagi 5 ta farqni toping!</p>',
            'age_from' => 4,
            'age_to' => 10,
            'order' => 2,
            'is_published' => true,
            'published_at' => now(),
        ]);

        Content::create([
            'chapter_id' => $chapter4->id,
            'section_id' => null,
            'title_ru' => 'Раскраски для малышей',
            'title_uz' => 'Kichkintoylar uchun bo\'yash rasmlari',
            'type' => 'file',
            'body_ru' => '<p>Bo\'yash uchun qiziqarli rasmlar to\'plami. PDF formatida yuklab oling.</p>',
            'file_url' => 'files/coloring-pages.pdf',
            'age_from' => 3,
            'age_to' => 7,
            'order' => 3,
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->command->info('✅ Boblar, bo\'limlar va materiallar muvaffaqiyatli yaratildi!');
    }
}

