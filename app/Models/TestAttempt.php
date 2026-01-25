<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * TestAttempt (Test urinishi) modeli
 * Foydalanuvchi natijasini saqlash uchun
 * 
 * @property int $id
 * @property int $test_id
 * @property int|null $user_id
 * @property int $score
 * @property int $total_questions
 * @property int $correct_answers
 * @property \Carbon\Carbon|null $started_at
 * @property \Carbon\Carbon|null $finished_at
 */
class TestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'user_id',
        'score',
        'total_questions',
        'correct_answers',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'score' => 'integer',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    /**
     * Urinish tegishli test
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Urinish amalga oshirgan foydalanuvchi (ixtiyoriy)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Foiz hisobini olish
     */
    public function getPercentageAttribute(): float
    {
        if ($this->total_questions === 0) {
            return 0;
        }
        return round(($this->correct_answers / $this->total_questions) * 100, 1);
    }

    /**
     * Test davomiyligi (soniyalarda)
     */
    public function getDurationInSecondsAttribute(): ?int
    {
        if ($this->started_at && $this->finished_at) {
            return $this->finished_at->diffInSeconds($this->started_at);
        }
        return null;
    }

    /**
     * Formatlangan davomiylik
     */
    public function getFormattedDurationAttribute(): ?string
    {
        $seconds = $this->duration_in_seconds;
        if ($seconds === null) {
            return null;
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes > 0) {
            return "{$minutes} мин {$remainingSeconds} сек";
        }
        return "{$remainingSeconds} сек";
    }
}

