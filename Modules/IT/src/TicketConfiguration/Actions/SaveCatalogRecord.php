<?php

namespace Modules\IT\TicketConfiguration\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\IT\TicketConfiguration\Catalog;

class SaveCatalogRecord
{
    public function handle(Catalog $catalog, array $data, ?int $id = null): Model
    {
        return DB::transaction(function () use ($catalog, $data, $id) {
            $record = $id ? $catalog->model()::lockForUpdate()->findOrFail($id) : new ($catalog->model());
            if ($catalog === Catalog::Categories && $id && !empty($data['parent_id'])
                && $record->children()->exists()) {
                throw ValidationException::withMessages(['parent_id' => 'A parent category with children cannot become a subcategory.']);
            }
            $record->fill($data)->save();

            return $record;
        });
    }
}
