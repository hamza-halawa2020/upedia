<?php

namespace Modules\IT\Expenses\Queries;

use App\Models\ExpenseHead;
use Modules\IT\Expenses\Filters\ExpenseFilters;
use Modules\IT\Expenses\Models\ItExpense;

class Expenses
{
    public function __construct(private readonly ExpenseFilters $filters) {}

    public function query(array $criteria = [])
    {
        return $this->filters->apply(ItExpense::query(), $criteria)->latest('id');
    }

    public function list(array $criteria)
    {
        return $this->query($criteria)->paginate($criteria['per_page'] ?? 10)->withQueryString();
    }

    public function find(int $id): ItExpense
    {
        return ItExpense::findOrFail($id);
    }

    public function heads()
    {
        return ExpenseHead::orderBy('name')->get(['id', 'name']);
    }
}
