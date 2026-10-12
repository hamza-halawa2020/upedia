<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationRequest extends Model
{
    protected $fillable = [
        'idempotency_key',
        'source_service',
        'source_type',
        'source_id',
        'external_reference',
        'operation',
        'request_hash',
        'response_status',
        'response_body',
        'resource_type',
        'resource_id',
        'status',
        'error_message',
    ];

    protected $casts = [
        'response_body' => 'array',
    ];
}
