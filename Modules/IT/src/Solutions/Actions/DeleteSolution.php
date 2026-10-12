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
            app(\App\Actions\Attachments\DeleteAttachments::class)->handle($solution);
            $solution->departments()->detach();
            $solution->delete();
        });
    }
}
