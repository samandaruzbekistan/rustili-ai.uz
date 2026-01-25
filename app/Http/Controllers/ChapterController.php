<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\View\View;

/**
 * ChapterController - Boblar uchun controller
 */
class ChapterController extends Controller
{
    /**
     * Bob sahifasini ko'rsatish
     * Bo'limlar va materiallarni birga ko'rsatish
     */
    public function show(string $locale, string $slug): View
    {
        $chapter = Chapter::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Bo'limlar ro'yxatini olish (agar mavjud bo'lsa)
        $sections = $chapter->activeSections()
            ->ordered()
            ->withCount(['contents' => function ($query) {
                $query->where('is_published', true);
            }])
            ->get();

        // Bo'limsiz materiallarni olish (to'g'ridan-to'g'ri bobga tegishli)
        $directContents = $chapter->directContents()
            ->where('type', '!=', 'riddle')
            ->ordered()
            ->get();
        
        // Topishmoqlar (riddle) materiallarni alohida olish
        $riddles = $chapter->directContents()
            ->where('type', 'riddle')
            ->ordered()
            ->get();

        return view('chapter.show', compact('chapter', 'sections', 'directContents', 'riddles'));
    }
}

