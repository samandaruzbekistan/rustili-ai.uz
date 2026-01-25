<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'word_ru',
        'word_uz',
        'image_path',
        'audio_path',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
