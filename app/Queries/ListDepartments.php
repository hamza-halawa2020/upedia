<?php

namespace App\Queries;

use App\Models\SmHumanDepartment;
use Illuminate\Support\Collection;

class ListDepartments
{
    public function handle(): Collection
    {
        return SmHumanDepartment::query()->orderBy('name')->get(['id', 'name']);
    }
}

