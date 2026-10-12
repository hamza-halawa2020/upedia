<?php

namespace Modules\IT\Solutions\Queries;

use App\Models\ItSolution;
use Modules\IT\Solutions\Filters\SolutionFilters;

class ManageSolutions
{
    public function __construct(private readonly SolutionFilters $filters) {}

    public function list(array $criteria)
    {
        return $this->filters->apply(ItSolution::with('departments:id,name'), $criteria)
            ->paginate(10)->withQueryString();
    }

    public function find(int $id): ItSolution
    {
        return ItSolution::with(['departments:id,name', 'attachments'])->findOrFail($id);
    }
}
