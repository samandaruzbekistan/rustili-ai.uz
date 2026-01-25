<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\View\View;

/**
 * ContentController - Materiallar uchun controller
 */
class ContentController extends Controller
{
    /**
     * Material tafsilotlari sahifasini ko'rsatish
     */
    public function show(string $locale, int $id): View
    {
        $content = Content::query()
            ->with(['chapter', 'section', 'test.questions.options'])
            ->where('is_published', true)
            ->findOrFail($id);

        // Qo'shni materiallar (avvalgi va keyingi)
        $prevContent = Content::query()
            ->where('chapter_id', $content->chapter_id)
            ->where('section_id', $content->section_id)
            ->where('is_published', true)
            ->where('order', '<', $content->order)
            ->orderByDesc('order')
            ->first();

        $nextContent = Content::query()
            ->where('chapter_id', $content->chapter_id)
            ->where('section_id', $content->section_id)
            ->where('is_published', true)
            ->where('order', '>', $content->order)
            ->orderBy('order')
            ->first();

        return view('content.show', compact('content', 'prevContent', 'nextContent'));
    }
}

