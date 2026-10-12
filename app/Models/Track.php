<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = 'tracks';

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
    

    public function track_levels()
    {
        return $this->hasMany(TrackLevel::class);
    }
    // public function trackLevels()
    // {
    //     return $this->hasMany(TrackLevel::class);
    // }
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name_en',
        'name_ar',
        'level_number',
        'session',
        'schedule',
        'valid_for',
    ];


    public function getValidForAttribute($value)
    {
        return json_decode($value);
    }

    public function invoice()
    {
        return $this->hasOne(FinanaceStudentInvoice::class,'product_id');
    }

    public function invoices()
    {
        return $this->hasMany(FinanaceStudentInvoice::class, 'product_id')
                    ->where('type', 'track');
    }
}
