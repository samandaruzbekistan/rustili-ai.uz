<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\View\View;

/**
 * HomeController - Bosh sahifa uchun controller
 */
class HomeController extends Controller
{
    /**
     * Bosh sahifani ko'rsatish
     * Barcha aktiv boblarni ro'yxati
     */
    public function index(): View
    {
        $chapters = Chapter::query()
            ->active()
            ->ordered()
            ->withCount(['sections', 'contents'])
            ->get();

        return view('home', compact('chapters'));
    }
}
