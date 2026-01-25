<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Bolalar uchun onlayn ta'lim/kutubxona seeder
        $this->call([
            ChapterSeeder::class,
        ]);
    }
}
