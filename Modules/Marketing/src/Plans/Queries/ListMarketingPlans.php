<?php

namespace Modules\Marketing\Plans\Queries;

use App\Models\MarketingPlan;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Marketing\Plans\Filters\MarketingPlanFilters;

class ListMarketingPlans
{
    public function __construct(private readonly MarketingPlanFilters $filters) {}

    public function paginate(array $criteria, User $user): LengthAwarePaginator
    {
        return $this->baseQuery($criteria, $user)
            ->orderByDesc('publish_date')
            ->paginate($this->perPage($criteria))->withQueryString();
    }

    public function collection(array $criteria, User $user): Collection
    {
        return $this->baseQuery($criteria, $user)
            ->orderByDesc('publish_date')
            ->get();
    }

    private function baseQuery(array $criteria, User $user): Builder
    {
        $query = MarketingPlan::query()->with(['staff:id,first_name,last_name']);
        $staff = $user->staff()->with('jobTitle:id,slug')->first();

        if ($staff && optional($staff->jobTitle)->slug === 'content-creator') {
            $query->where('created_by', $staff->id);
        }

        return $this->filters->apply($query, $criteria);
    }

    private function perPage(array $criteria): int
    {
        return (int) ($criteria['per_page'] ?? 10);
    }
}
