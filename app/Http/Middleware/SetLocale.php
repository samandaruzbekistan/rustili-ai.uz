<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * SetLocale Middleware
 * Tilni sozlash va saqlash uchun
 */
class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // URL dan tilni olish (uz yoki ru)
        $locale = $request->route('locale');
        
        // Agar route parametridan til olinmasa, segmentdan olish
        if (!$locale) {
            $locale = $request->segment(1);
        }
        
        // Agar til mavjud bo'lsa va qo'llab-quvvatlanadigan tillardan biri bo'lsa
        if (in_array($locale, ['uz', 'ru'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Default til (ru)
            $locale = Session::get('locale', 'ru');
            App::setLocale($locale);
        }
        
        return $next($request);
    }
}

