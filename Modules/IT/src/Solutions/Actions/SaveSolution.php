<?php

namespace Modules\IT\Solutions\Actions;

use App\Models\ItSolution;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SaveSolution
{
    public function handle(array $data, ?int $id = null): ItSolution
    {
        return DB::transaction(function () use ($data, $id) {
            $solution = $id ? ItSolution::lockForUpdate()->findOrFail($id) : new ItSolution();
            $solution->fill(Arr::except($data, ['department_ids']))->save();
            $solution->departments()->sync($data['visibility'] === 'departments' ? $data['department_ids'] : []);

            return $solution;
        });
    }
}
