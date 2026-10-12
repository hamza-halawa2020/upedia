<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RetentionSetting extends Model
{
    protected $table = 'retention_settings';

    protected $fillable = [
        'key', 
        'value',
        'description'
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("retention_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }


    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("retention_setting_{$key}");
    }
}
