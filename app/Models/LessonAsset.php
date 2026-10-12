<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonAsset extends Model
{
    protected $table = 'lesson_assets';
    protected $fillable = [
        'lesson_id',
        'type',
        'url',
    ];

    public function lesson()
    {
        return $this->belongsTo(SessionLesson::class, 'lesson_id');
    }
}
