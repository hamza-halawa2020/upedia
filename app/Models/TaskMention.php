<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMention extends Model
{
    /** @use HasFactory<\Database\Factories\TaskMentionsFactory> */
    use HasFactory;

    protected $table = 'task_mentions';
    protected $fillable = ['task_id' , 'staff_id' , 'job_title_slug'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }



}
