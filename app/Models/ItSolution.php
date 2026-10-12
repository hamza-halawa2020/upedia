<?php

namespace App\Models;

use App\Models\Attachment;
use App\Models\SmHumanDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Traits\Viewable;

class ItSolution extends Model
{
    use Viewable;

    protected $fillable = [
        'title',
        'topic_name',
        'description',
        'keywords',
        'visibility',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(
            SmHumanDepartment::class,
            'it_solution_sm_human_department',
            'it_solution_id',
            'sm_human_department_id'
        );
    }
}