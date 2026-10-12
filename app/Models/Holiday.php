<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Holiday extends Model
{
    use HasFactory;

    protected $table = 'sm_holidays';

    protected $fillable = [
        'holiday_title',
        'details',
        'from_date',
        'to_date',
        'upload_image_file',
        'active_status',
        'created_by',
        'updated_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
