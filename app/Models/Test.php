<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Test modeli
 * Content type = 'test' bo'lganda ishlatiladi
 * 
 * @property int $id
 * @property int $content_id
 * @property string $title
 * @property string|null $description
 * @property int|null $time_limit
 * @property int|null $attempts_allowed
 * @property bool $is_active
 */
class Test extends Model
{
    use HasFactory;

    // Tests jadvalidan foydalanish uchun
    protected $table = 'tests';

    protected $fillable = [
        'content_id',
        'title',
        'description',
        'time_limit',
        'attempts_allowed',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_limit' => 'integer',
        'attempts_allowed' => 'integer',
    ];

    /**
     * Test bog'langan kontent
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Test savollari
     */
    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class)->orderBy('order');
    }

    /**
     * Test urinishlari
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    /**
     * Savollar sonini olish
     */
    public function getQuestionsCountAttribute(): int
    {
        return $this->questions()->count();
    }

    /**
     * Aktiv testlar scope
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

