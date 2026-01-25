<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Chapters (Boblar) jadvali migratsiyasi
 * Asosiy katta bo'limlarni saqlash uchun
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->string('title_ru'); // Ruscha nom
            $table->string('title_uz')->nullable(); // O'zbekcha nom
            $table->string('slug')->unique(); // URL uchun unikal slug
            $table->text('description')->nullable(); // Tavsif
            $table->string('icon')->nullable(); // Emoji yoki ikon class nomi
            $table->string('cover_image')->nullable(); // Bob rasmi (banner/kartochka)
            $table->enum('default_content_type', [
                'text', 'audio', 'video', 'file', 'test', 'image', 'mixed'
            ])->nullable(); // Default kontent turi
            $table->integer('order')->default(0); // Tartib raqami
            $table->boolean('is_active')->default(true); // Faollik holati
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};

