<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * SectionController - Bo'limlar uchun controller
 */
class SectionController extends Controller
{
    /**
     * Bo'lim sahifasini ko'rsatish
     * Bo'limga tegishli materiallar ro'yxati
     */
    public function show(Request $request, string $locale, string $chapterSlug, string $sectionSlug): View
    {
        $chapter = Chapter::query()
            ->where('slug', $chapterSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $section = Section::query()
            ->where('chapter_id', $chapter->id)
            ->where('slug', $sectionSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Materiallarni olish (filter bilan)
        $contentsQuery = $section->publishedContents()->ordered();

        // Yosh bo'yicha filter
        if ($request->has('age_from') && $request->has('age_to')) {
            $contentsQuery->forAgeRange(
                (int) $request->age_from,
                (int) $request->age_to
            );
        }

        // Tur bo'yicha filter
        if ($request->has('type')) {
            $contentsQuery->ofType($request->type);
        }

        // Oddiy materiallar (riddle bo'lmagan)
        $contents = $contentsQuery->where('type', '!=', 'riddle')->get();
        
        // Topishmoqlar (riddle) materiallarni alohida yangi query bilan olish
        $riddlesQuery = $section->publishedContents()->ordered()->where('type', 'riddle');
        
        // Yosh bo'yicha filter (topishmoqlar uchun ham)
        if ($request->has('age_from') && $request->has('age_to')) {
            $riddlesQuery->forAgeRange(
                (int) $request->age_from,
                (int) $request->age_to
            );
        }
        
        $riddles = $riddlesQuery->get();

        return view('section.show', compact('chapter', 'section', 'contents', 'riddles'));
    }
}

