<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJournalEntryImport extends Model
{
    protected $fillable = [
        'source_system',
        'external_reference',
        'payload',
        'error_message',
        'error_class',
        'http_status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}

