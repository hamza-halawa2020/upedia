<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{

    public $timestamps = true;
    protected $fillable = [
        'label',
        'url',
        'icon',
        'parent_id',
        'permission_required',
        'order',
        'systems'
    ];

    protected $casts = [
        'systems' => 'array'
    ];

    public function getUrlAttribute($value)
    {
        return self::normalizeUrlForCurrentHost($value);
    }

    public function children()
    {
        return $this->hasMany(Tab::class, 'parent_id')->orderBy('order','asc');
        
    }

    public function parent()
    {
        return $this->belongsTo(Tab::class, 'parent_id');
    }

    public function departments()
    {
        return $this->belongsToMany(SmHumanDepartment::class, 'department_tab', 'tab_id', 'department_id')->withPivot('order');
    }

    protected static function normalizeUrlForCurrentHost(?string $url): ?string
    {
        if (!$url || $url === '#' || str_contains($url, 'javascript:void(0)')) {
            return $url;
        }

        $parts = parse_url($url);

        if ($parts === false || empty($parts['host'])) {
            return $url;
        }

        $currentClient = self::resolveClientSlug(request()->getHost());
        $storedClient = self::resolveClientSlug($parts['host']);

        if (!$currentClient || !$storedClient || $currentClient === $storedClient) {
            return $url;
        }

        $parts['host'] = preg_replace(
            '/' . preg_quote($storedClient, '/') . '/',
            $currentClient,
            $parts['host'],
            1
        );

        return self::buildUrl($parts);
    }

    protected static function resolveClientSlug(?string $host): ?string
    {
        if (!$host) {
            return null;
        }

        foreach (['alkarim', 'upedia', 'tailors'] as $client) {
            if (str_contains(strtolower($host), $client)) {
                return $client;
            }
        }

        return null;
    }

    protected static function buildUrl(array $parts): string
    {
        $scheme = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
        $user = $parts['user'] ?? '';
        $pass = isset($parts['pass']) ? ':' . $parts['pass'] : '';
        $auth = $user !== '' ? $user . $pass . '@' : '';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $path = $parts['path'] ?? '';
        $query = isset($parts['query']) ? '?' . $parts['query'] : '';
        $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';

        return $scheme . $auth . $host . $port . $path . $query . $fragment;
    }
}
