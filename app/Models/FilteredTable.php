<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilteredTable extends Model
{
    protected $fillable = [
        'table_name',
        'model',
        'file_name',
        'file_path',
        'file_url',
        'filters',
        'total_rows',
    ];

    protected $casts = [
        'filters' => 'array',
    ];
}
