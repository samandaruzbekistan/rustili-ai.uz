<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Content (Material) modeli
 * Ertak, she'r, topishmoq, test, audio, video va h.k.
 *
 * @property int $id
 * @property int $chapter_id
 * @property int|null $section_id
 * @property string $title_ru
 * @property string|null $title_uz
 * @property string $type
 * @property string|null $body_ru
 * @property string|null $body_uz
 * @property string|null $audio_url
 * @property string|null $audio_path
 * @property string|null $video_url
 * @property string|null $file_url
 * @property string|null $cover_image
 * @property int|null $age_from
 * @property int|null $age_to
 * @property bool $is_published
 * @property \Carbon\Carbon|null $published_at
 * @property int $order
 */
class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'section_id',
        'title_ru',
        'title_uz',
        'type',
        'body_ru',
        'body_uz',
        'audio_url',
        'audio_path',
        'video_url',
        'file_url',
        'cover_image',
        'age_from',
        'age_to',
        'is_published',
        'published_at',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'order' => 'integer',
        'age_from' => 'integer',
        'age_to' => 'integer',
    ];

    /**
     * Kontent turlari
     */
    public const CONTENT_TYPES = [
        'text' => 'Matn',
        'audio' => 'Audio',
        'video' => 'Video',
        'file' => 'Fayl',
        'test' => 'Test',
        'image' => 'Rasm',
        'mixed' => 'Aralash',
        'riddle' => 'Topishmoq',
    ];

    /**
     * Kontent tegishli bo'lgan bob
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Kontent tegishli bo'lgan bo'lim (ixtiyoriy)
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Kontent bilan bog'langan test (agar type = 'test' bo'lsa)
     */
    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    /**
     * Kontent turi ikonkasi
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'audio' => '🎧',
            'video' => '🎬',
            'text' => '📖',
            'file' => '📁',
            'test' => '📝',
            'image' => '🖼️',
            'mixed' => '🎨',
            'riddle' => '❓',
            default => '📄',
        };
    }

    /**
     * Yosh diapazoni formatlangan
     */
    public function getAgeRangeAttribute(): ?string
    {
        if ($this->age_from && $this->age_to) {
            return "{$this->age_from}–{$this->age_to} лет";
        } elseif ($this->age_from) {
            return "от {$this->age_from} лет";
        } elseif ($this->age_to) {
            return "до {$this->age_to} лет";
        }
        return null;
    }

    /**
     * Chop etilgan kontentlar scope
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Tartib bo'yicha scope
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Yosh bo'yicha filter scope
     */
    public function scopeForAge($query, int $age)
    {
        return $query->where(function ($q) use ($age) {
            $q->whereNull('age_from')
                ->orWhere('age_from', '<=', $age);
        })->where(function ($q) use ($age) {
            $q->whereNull('age_to')
                ->orWhere('age_to', '>=', $age);
        });
    }

    /**
     * Yosh diapazoni bo'yicha filter scope
     */
    public function scopeForAgeRange($query, ?int $from = null, ?int $to = null)
    {
        if ($from !== null) {
            $query->where(function ($q) use ($from) {
                $q->whereNull('age_from')
                    ->orWhere('age_from', '>=', $from);
            });
        }

        if ($to !== null) {
            $query->where(function ($q) use ($to) {
                $q->whereNull('age_to')
                    ->orWhere('age_to', '<=', $to);
            });
        }

        return $query;
    }

    /**
     * Tur bo'yicha filter scope
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}

