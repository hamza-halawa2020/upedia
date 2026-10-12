<?php

namespace App\Traits;

use App\Models\View;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Schema;

trait Viewable
{
    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function recordView(?int $userId = null, ?string $ipAddress = null, ?string $userAgent = null): View
    {
        $view = $this->views()->create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        if (Schema::hasColumn($this->getTable(), 'views_count')) {
            static::withoutTimestamps(fn () => $this->increment('views_count'));
        }

        return $view;
    }
}
