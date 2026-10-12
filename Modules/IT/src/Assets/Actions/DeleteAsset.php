<?php

namespace Modules\IT\Assets\Actions;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;

class DeleteAsset
{
    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $asset = Asset::lockForUpdate()->findOrFail($id);
            $asset->accessories()->delete();
            $asset->delete();
        });
    }
}
