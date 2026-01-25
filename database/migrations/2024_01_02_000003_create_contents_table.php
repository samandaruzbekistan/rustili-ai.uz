<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Contents (Materiallar) jadvali migratsiyasi
 * Ertak, she'r, topishmoq, test, audio, video va h.k.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            
            // Bob bilan bog'lanish (majburiy)
            $table->foreignId('chapter_id')
                ->constrained('chapters')
                ->cascadeOnDelete();
            
            // Bo'lim bilan bog'lanish (ixtiyoriy)
            // Ba'zi boblarda bo'lim bo'lmaydi, content faqat chapter_id bilan bog'lanadi
            $table->foreignId('section_id')
                ->nullable()
                ->constrained('sections')
                ->nullOnDelete();
            
            $table->string('title_ru'); // Ruscha nom
            $table->string('title_uz')->nullable(); // O'zbekcha nom
            
            // Material turi
            $table->enum('type', [
                'text',     // Ertaklar, hikoyalar, topishmoqlar, she'rlar
                'audio',    // Audio ertaklar (audio player bilan)
                'video',    // Multfilmlar (video iframe yoki video player)
                'file',     // Yuklab olinadigan fayllar (pdf, doc va h.k.)
                'test',     // Testlar
                'image',    // Rasm, rasm chizishga oid materiallar
                'mixed'     // Matn + audio + rasm aralash variant
            ])->default('text');
            
            // Matn kontenti
            $table->longText('body_ru')->nullable(); // Ruscha matn
            $table->longText('body_uz')->nullable(); // O'zbekcha matn
            
            // Media fayllar
            $table->string('audio_url')->nullable(); // Audio fayl manzili
            $table->string('video_url')->nullable(); // Video manzili (YouTube, mp4)
            $table->string('file_url')->nullable(); // Yuklab olinadigan fayl linki
            $table->string('cover_image')->nullable(); // Material uchun rasm
            
            // Yosh chegaralari
            $table->tinyInteger('age_from')->nullable(); // Minimal yosh (masalan, 3)
            $table->tinyInteger('age_to')->nullable(); // Maksimal yosh (masalan, 10)
            
            // Holat va tartib
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->integer('order')->default(0);
            
            $table->timestamps();
            
            // Indekslar
            $table->index(['chapter_id', 'section_id']);
            $table->index(['type', 'is_published']);
            $table->index(['age_from', 'age_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};

