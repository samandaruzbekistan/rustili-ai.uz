<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE contents MODIFY COLUMN type ENUM('text', 'audio', 'video', 'file', 'test', 'image', 'mixed', 'riddle') DEFAULT 'text'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE contents MODIFY COLUMN type ENUM('text', 'audio', 'video', 'file', 'test', 'image', 'mixed') DEFAULT 'text'");
    }
};
