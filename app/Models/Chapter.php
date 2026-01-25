<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Chapter (Bob) modeli
 * Asosiy katta bo'limlarni ifodalaydi
 * 
 * @property int $id
 * @property string $title_ru
 * @property string|null $title_uz
 * @property string $slug
 * @property string|null $description
 * @property string|null $icon
 * @property string|null $cover_image
 * @property string|null $default_content_type
 * @property int $order
 * @property bool $is_active
 */
class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ru',
        'title_uz',
        'slug',
        'description',
        'icon',
        'cover_image',
        'default_content_type',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Slug avtomatik generatsiyasi
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chapter) {
            if (empty($chapter->slug)) {
                $chapter->slug = Str::slug($chapter->title_ru);
            }
        });
    }

    /**
     * Bobga tegishli bo'limlar
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    /**
     * Bobga tegishli barcha materiallar
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    /**
     * Faqat aktiv bo'limlar
     */
    public function activeSections(): HasMany
    {
        return $this->sections()->where('is_active', true);
    }

    /**
     * Bo'limsiz materiallar (section_id = null)
     */
    public function directContents(): HasMany
    {
        return $this->contents()->whereNull('section_id')->where('is_published', true);
    }

    /**
     * Bobda bo'limlar bormi?
     */
    public function hasSections(): bool
    {
        return $this->sections()->exists();
    }

    /**
     * Aktiv boblar scope
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
}

