<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sections (Bo'limlar) jadvali migratsiyasi
 * Faqat ayrim boblarda bo'ladi
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')
                ->constrained('chapters')
                ->cascadeOnDelete(); // Bob o'chirilsa, bo'lim ham o'chadi
            $table->string('title_ru'); // Ruscha nom
            $table->string('title_uz')->nullable(); // O'zbekcha nom
            $table->string('slug')->unique(); // URL uchun unikal slug
            $table->text('description')->nullable(); // Tavsif
            $table->string('cover_image')->nullable(); // Bo'lim rasmi
            $table->enum('section_type', [
                'generic',  // Oddiy bo'lim (ertaklar, she'rlar)
                'text',     // Ko'proq matn bo'lgan bo'limlar
                'audio',    // Audio ertaklar
                'video',    // Multfilmlar
                'file',     // Asosan fayllar yuklanadigan bo'lim
                'test',     // Test joylanadigan bo'lim
                'mixed'     // Aralash
            ])->default('generic');
            $table->integer('order')->default(0); // Tartib raqami
            $table->boolean('is_active')->default(true); // Faollik holati
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

