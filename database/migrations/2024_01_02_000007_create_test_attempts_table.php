<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Test Attempts (Test urinishlari) jadvali migratsiyasi
 * Foydalanuvchi natijasini saqlash uchun
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('test_id')
                ->constrained('tests')
                ->cascadeOnDelete();
            
            // Anonim foydalanuvchilar uchun nullable
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            
            $table->integer('score'); // Ball
            $table->integer('total_questions'); // Jami savollar soni
            $table->integer('correct_answers'); // To'g'ri javoblar soni
            
            $table->timestamp('started_at')->nullable(); // Boshlangan vaqt
            $table->timestamp('finished_at')->nullable(); // Tugagan vaqt
            
            $table->timestamps();
            
            // Indekslar
            $table->index(['test_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};

