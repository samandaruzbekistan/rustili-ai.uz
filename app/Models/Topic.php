<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ru',
        'title_uz',
        'slug',
        'description',
        'emoji',
        'order',
    ];

    public function lessonItems()
    {
        return $this->hasMany(LessonItem::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }
}
