<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'user_identifier',
        'score',
        'total_questions',
        'correct_answers',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
