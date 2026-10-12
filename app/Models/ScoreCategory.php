<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreCategory extends Model
{
    protected $table = 'score_categories';
    protected $fillable = ['name'];

    public function sections()
    {
        return $this->hasMany(ScoreSection::class,'category_id');
    }
}
