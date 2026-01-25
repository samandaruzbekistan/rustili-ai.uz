<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Bolalar uchun onlayn ta'lim/kutubxona - Web Routes
|--------------------------------------------------------------------------
*/

// Til o'zgartirish route'i
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['uz', 'ru'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');

// Locale prefix bilan route'lar
Route::prefix('{locale}')->where(['locale' => 'uz|ru'])->middleware('locale')->group(function () {
    // Bosh sahifa - Barcha boblar ro'yxati
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Bo'lim sahifasi - Materiallar ro'yxati (anroq route oldin bo'lishi kerak)
    Route::get('/chapter/{chapterSlug}/section/{sectionSlug}', [SectionController::class, 'show'])
        ->where('chapterSlug', '[a-z0-9\-]+')
        ->where('sectionSlug', '[a-z0-9\-]+')
        ->name('section.show');

    // Bob sahifasi - Bo'limlar yoki materiallar ro'yxati
    Route::get('/chapter/{slug}', [ChapterController::class, 'show'])
        ->where('slug', '[a-z0-9\-]+')
        ->name('chapter.show');

    // Material tafsilotlari sahifasi
    Route::get('/content/{id}', [ContentController::class, 'show'])
        ->name('content.show')
        ->whereNumber('id');

    // Test routes
    Route::prefix('test')->name('test.')->group(function () {
        Route::get('/{id}', [TestController::class, 'show'])
            ->name('show')
            ->whereNumber('id');

        Route::post('/{id}/submit', [TestController::class, 'submit'])
            ->name('submit')
            ->whereNumber('id');

        Route::get('/{id}/result/{attemptId}', [TestController::class, 'result'])
            ->name('result')
            ->whereNumber(['id', 'attemptId']);
    });
});

// Root route - default tilga redirect
Route::get('/', function () {
    $locale = session('locale', 'ru');
    return redirect("/{$locale}");
})->name('root');
