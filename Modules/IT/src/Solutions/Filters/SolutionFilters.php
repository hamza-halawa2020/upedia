<?php

namespace Modules\IT\Solutions\Filters;

use Illuminate\Database\Eloquent\Builder;

class SolutionFilters
{
    public function apply(Builder $query, array $criteria): Builder
    {
        if ($search = $criteria['search'] ?? null) {
            $query->where(function (Builder $query) use ($search) {
                foreach (['title', 'description', 'keywords', 'topic_name'] as $field) {
                    $query->orWhere($field, 'like', '%'.$search.'%');
                }
            });
        }

        return match ($criteria['sort'] ?? 'latest') {
            'popular' => $query->orderByDesc('views_count')->orderByDesc('id'),
            'az' => $query->orderBy('title')->orderBy('id'),
            default => $query->latest('id'),
        };
    }
}
