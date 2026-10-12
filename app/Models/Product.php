<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends CrmModel
{
    protected $table = 'crm_products';

    protected $appends = ['name'];

    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'related_to');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class)->withDefault();
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class)->withDefault();
    }

    public function scopeWithAccount($query)
    {
        return $query->with('account');
    }

    public function scopeWithContact($query) {
        return $query->with('contact');
    }

    public function withTasks($query)
    {
        return $query->with('tasks');
    }

    public function track_level()
    {
        return $this->belongsTo(TrackLevel::class,'product_id')->withDefault();
    }
    
    public function product(){
        return $this->belongsTo(AcademyProduct::class,'product_id')->withDefault();
    }

    public function invoice()
    {
        return $this->hasMany(FinanaceStudentInvoice::class,'product_id');
    }

    public function getNameAttribute(): string
    {
        return $this->product?->name_en
            ?? $this->product?->name_ar
            ?? ('Product #' . $this->id);
    }
}
