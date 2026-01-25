<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tests jadvali migratsiyasi
 * Content type = 'test' bo'lganda ishlatiladi
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            
            // Content bilan bog'lanish (type = 'test' bo'lgan contentga)
            $table->foreignId('content_id')
                ->constrained('contents')
                ->cascadeOnDelete();
            
            $table->string('title'); // Test nomi
            $table->text('description')->nullable(); // Test tavsifi
            $table->integer('time_limit')->nullable(); // Vaqt chegarasi (daqiqalarda)
            $table->integer('attempts_allowed')->nullable(); // Ruxsat berilgan urinishlar soni
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};

