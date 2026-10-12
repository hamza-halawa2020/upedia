<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $table = 'chart_of_accounts';

    protected $fillable = [
        'code',
        'title',
        'name_en',
        'slug',
        'parent_id',
        'account_type',
        'account_subtype',
        'account_nature',
        'is_nature_inherited',
        'status',
        'created_by',
        'can_delete',
        'is_system',
    ];

    protected $casts = [
        'is_nature_inherited' => 'boolean',
        'can_delete' => 'boolean',
        'is_system' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function canDeleteOrUpdate(): bool
    {
        return (bool) $this->can_delete && !$this->children()->exists();
    }

    public function getNatureLabelAttribute(): string
    {
        return match ($this->account_nature) {
            'debit' => 'Debit increases',
            'credit' => 'Credit increases',
            default => 'Not set',
        };
    }

}
