<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Test Questions (Test savollari) jadvali migratsiyasi
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('test_id')
                ->constrained('tests')
                ->cascadeOnDelete();
            
            $table->text('question_text'); // Savol matni
            $table->string('image')->nullable(); // Savol uchun rasm
            $table->integer('order')->default(0); // Tartib raqami
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_questions');
    }
};

