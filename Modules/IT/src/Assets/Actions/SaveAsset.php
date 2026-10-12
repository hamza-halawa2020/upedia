<?php

namespace Modules\IT\Assets\Actions;

use App\Models\Asset;
use App\Models\AssetAccessory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SaveAsset
{
    public function handle(array $data, ?int $id = null): Asset
    {
        return DB::transaction(function () use ($data, $id) {
            $asset = $id ? Asset::lockForUpdate()->findOrFail($id) : new Asset;
            $asset->fill(Arr::except($data, ['accessories']))->save();
            if (array_key_exists('accessories', $data)) {
                $asset->accessories()->delete();
                $now = now();
                $rows = collect($data['accessories'])->map(fn ($item) => [
                    'asset_id' => $asset->id, 'type' => $item['name'], 'enabled' => (bool) $item['enabled'],
                    'brand' => $item['enabled'] ? ($item['brand'] ?? null) : null,
                    'cost' => $item['enabled'] ? ($item['cost'] ?? 0) : null, 'created_at' => $now, 'updated_at' => $now]);
                if ($rows->isNotEmpty()) {
                    DB::table((new AssetAccessory)->getTable())->insert($rows->all());
                }
            }

            return $asset;
        });
    }
}
