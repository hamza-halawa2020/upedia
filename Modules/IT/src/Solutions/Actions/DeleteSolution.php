<?php

namespace Modules\IT\Solutions\Actions;

use App\Models\ItSolution;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DeleteSolution
{
    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $solution = ItSolution::lockForUpdate()->findOrFail($id);
            if ($solution->attachments()->exists()) {
                throw ValidationException::withMessages(['solution' => 'Attachment deletion is not migrated yet. This solution cannot be deleted.']);
            }
            $solution->departments()->detach();
            $solution->delete();
        });
    }
}
