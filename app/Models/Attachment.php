<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'hr_attachments';
    protected $fillable = [
        'model_id',
        'model_type',
        'file_path',
        'file_type',
        'original_name'
    ];
    public function attachable()
    {
        return $this->morphTo();
    }
}
