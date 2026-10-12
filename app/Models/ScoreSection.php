<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreSection extends Model
{

    protected $table = 'score_sections';
    protected $fillable =
    [
        'category_id',
        'title'
    ];

    public function category()
    {
        return $this->belongsTo(ScoreCategory::class,'category_id');
    }

    public function questions()
    {
        return $this->hasMany(ScoreQuestion::class,'section_id');
    }
}
