<?php

if (!function_exists('locale_url')) {
    /**
     * Locale bilan URL yaratish
     */
    function locale_url(string $route, array $parameters = [], ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        // Route'ga locale parametrini qo'shish
        $routeParameters = array_merge(['locale' => $locale], $parameters);
        
        try {
            $url = route($route, $routeParameters, false);
            
            // Agar URL'da locale ikki marta bo'lsa (masalan /ru/ru), bittasini olib tashlash
            $url = preg_replace('/\/(uz|ru)\/(uz|ru)(\/|$)/', '/$1$3', $url);
            
            return $url;
        } catch (\Exception $e) {
            // Agar route topilmasa, locale bilan bosh sahifaga qaytarish
            return "/{$locale}";
        }
    }
}

if (!function_exists('current_locale')) {
    /**
     * Joriy tilni olish
     */
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('other_locale')) {
    /**
     * Boshqa tilni olish
     */
    function other_locale(): string
    {
        return current_locale() === 'ru' ? 'uz' : 'ru';
    }
}

if (!function_exists('switch_locale_url')) {
    /**
     * Til o'zgartirish URL'i
     */
    function switch_locale_url(?string $locale = null): string
    {
        $locale = $locale ?? other_locale();
        $currentPath = request()->path();
        
        // Agar URL locale bilan boshlansa, uni almashtirish
        if (preg_match('/^(uz|ru)(\/|$)/', $currentPath, $matches)) {
            $currentPath = preg_replace('/^(uz|ru)(\/|$)/', '', $currentPath);
        }
        
        // Boshidan va oxiridan slash'larni olib tashlash
        $currentPath = trim($currentPath, '/');
        
        // Agar path bo'sh bo'lsa, faqat locale qaytarish
        if (empty($currentPath)) {
            return "/{$locale}";
        }
        
        return "/{$locale}/{$currentPath}";
    }
}

