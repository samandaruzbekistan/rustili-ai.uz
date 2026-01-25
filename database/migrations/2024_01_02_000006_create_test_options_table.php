<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Test Options (Javob variantlari) jadvali migratsiyasi
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_options', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('question_id')
                ->constrained('test_questions')
                ->cascadeOnDelete();
            
            $table->text('option_text'); // Variant matni
            $table->boolean('is_correct')->default(false); // To'g'ri javobmi?
            $table->integer('order')->default(0); // Tartib raqami
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_options');
    }
};

