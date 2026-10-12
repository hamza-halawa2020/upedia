<?php

namespace Modules\IT\Products\Actions;

use App\Models\Asset;
use App\Models\AssetAccessory;
use App\Models\ItProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Notifications\Actions\NotifyActor;

class DeleteProduct
{
    public function __construct(private readonly NotifyActor $notifications) {}

    public function handle(int $id, ?User $actor): void
    {
        DB::transaction(function () use ($id, $actor) {
            $product = ItProduct::query()->lockForUpdate()->findOrFail($id);
            $assets = Asset::query()->where('product_id', $product->id);
            AssetAccessory::query()->whereIn('asset_id', (clone $assets)->select('id'))->delete();
            $assets->delete();
            $product->delete();
            $this->notifications->handle($actor, 'Product #'.$id.' has been deleted.',
                'Product Deleted', ['it.products.index']);
        });
    }
}
