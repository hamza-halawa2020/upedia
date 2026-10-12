<?php

namespace Modules\Marketing\Scripts\Queries;

use App\Models\Script;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Marketing\Scripts\Filters\ScriptFilters;

class ListScripts
{
    public function __construct(private readonly ScriptFilters $filters)
    {
    }

    public function paginate(array $criteria, User $user): LengthAwarePaginator
    {
        return $this->baseQuery($criteria, $user)->latest()->paginate($this->perPage($criteria));
    }

    public function collection(array $criteria, User $user): Collection
    {
        return $this->baseQuery($criteria, $user)->latest()->get();
    }

    private function baseQuery(array $criteria, User $user): Builder
    {
        $query = Script::query()->with(['creator', 'departments:id,name,slug', 'approver']);
        $staff = $user->staff()->with(['department:id,slug', 'jobTitle:id,slug'])->first();

        if ($staff && $staff->department?->slug !== 'marketing' && ! $user->hasRole('Super admin')) {
            $query->where(fn ($q) => $q->where(fn ($nested) => $nested
                ->whereHas('departments', fn ($sq) => $sq->where('sm_human_departments.id', $staff->department_id))
                ->where('status', 'approved'))
                ->orWhere('created_by', $user->id));
        }

        return $this->filters->apply($query, $criteria);
    }

    private function perPage(array $criteria): int
    {
        return (int) ($criteria['per_page'] ?? 10);
    }
}

