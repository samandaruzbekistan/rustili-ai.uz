<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Section (Bo'lim) modeli
 * Boblar ichidagi kichik bo'limlarni ifodalaydi
 *
 * @property int $id
 * @property int $chapter_id
 * @property string $title_ru
 * @property string|null $title_uz
 * @property string $slug
 * @property string|null $description
 * @property string|null $cover_image
 * @property string $section_type
 * @property int $order
 * @property bool $is_active
 */
class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'title_ru',
        'title_uz',
        'slug',
        'description',
        'cover_image',
        'section_type',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Bo'lim turlari
     */
    public const SECTION_TYPES = [
        'generic' => 'Umumiy',
        'text' => 'Matn',
        'audio' => 'Audio',
        'video' => 'Video',
        'file' => 'Fayl',
        'test' => 'Test',
        'mixed' => 'Aralash',
    ];

    /**
     * Slug avtomatik generatsiyasi
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->title_ru);
            }
        });
    }

    /**
     * Bo'lim tegishli bo'lgan bob
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Bo'limga tegishli materiallar
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    /**
     * Faqat chop etilgan materiallar
     */
    public function publishedContents(): HasMany
    {
        return $this->contents()->where('is_published', true);
    }

    /**
     * Bo'lim turi ikonkasi
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->section_type) {
            'audio' => '🎧',
            'video' => '🎬',
            'text' => '📖',
            'file' => '📁',
            'test' => '📝',
            'mixed' => '🎨',
            default => '📚',
        };
    }

    /**
     * Aktiv bo'limlar scope
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Tartib bo'yicha scope
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Description'ni to'g'ri formatda qaytarish (rasm URL'laridagi &quot; ni tozalash)
     */
    public function getFormattedDescriptionAttribute(): ?string
    {
        if (!$this->description) {
            return null;
        }

        // Faqat &quot; ni tozalash, barcha URL'larni saqlab qolish
        $description = str_replace('&quot;', '"', $this->description);

        // Storage URL'larini to'g'ri formatda qaytarish (faqat storage URL'lar uchun)
        // Internetdan copy qilingan URL'lar o'zgartirilmaydi
        $description = preg_replace_callback(
            '/src=["\']([^"\']*storage\/[^"\']*)["\']/i',
            function ($matches) {
                $url = trim($matches[1], '"');
                // Agar URL /storage/ bilan boshlanmasa, qo'shish
                if (strpos($url, '/storage/') === false && strpos($url, 'storage/') !== false) {
                    $url = '/' . $url;
                }
                // Agar URL /storage/ bilan boshlansa, asset() qo'shish
                if (strpos($url, '/storage/') === 0) {
                    $url = asset($url);
                }
                return 'src="' . $url . '"';
            },
            $description
        );

        return $description;
    }
}

