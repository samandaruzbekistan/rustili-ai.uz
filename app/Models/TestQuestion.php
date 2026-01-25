<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * TestQuestion (Test savoli) modeli
 * 
 * @property int $id
 * @property int $test_id
 * @property string $question_text
 * @property string|null $image
 * @property int $order
 */
class TestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question_text',
        'image',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Savol tegishli test
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Savol uchun javob variantlari
     */
    public function options(): HasMany
    {
        return $this->hasMany(TestOption::class, 'question_id')->orderBy('order');
    }

    /**
     * To'g'ri javob variantini olish
     */
    public function correctOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }

    /**
     * Tartib bo'yicha scope
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

