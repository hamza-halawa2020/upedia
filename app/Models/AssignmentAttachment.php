<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentAttachment extends Model
{
    protected $table = 'assignment_attachments';
    protected $fillable = [
        'file',
         'assignment_id'
        ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}