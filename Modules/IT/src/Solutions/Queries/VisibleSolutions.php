<?php

namespace Modules\IT\Solutions\Queries;

use App\Models\ItSolution;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Modules\IT\Solutions\Filters\SolutionFilters;

class VisibleSolutions
{
    public function __construct(private readonly SolutionFilters $filters) {}

    public function query(User $user): Builder
    {
        $departmentId = $user->staff?->department_id;
        $isIt = $user->can('it_solutions_create');

        return ItSolution::with(['departments:id,name', 'attachments'])->where(function (Builder $query) use ($departmentId, $isIt) {
            $query->where('visibility', 'all');
            if ($isIt) {
                $query->orWhere('visibility', 'it_only');
            }
            if ($departmentId) {
                $query->orWhere(function (Builder $query) use ($departmentId) {
                    $query->where('visibility', 'departments')->whereHas('departments',
                        fn (Builder $query) => $query->where('sm_human_departments.id', $departmentId));
                });
            }
        });
    }

    public function list(User $user, array $criteria)
    {
        return $this->filters->apply($this->query($user), $criteria)->paginate(10)->withQueryString();
    }

    public function find(User $user, int $id): ItSolution
    {
        return $this->query($user)->findOrFail($id);
    }
}
