<?php

namespace Modules\IT\Products\Actions;

use App\Models\ItProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Notifications\Actions\NotifyActor;

class UpdateProduct
{
    public function __construct(private readonly NotifyActor $notifications) {}

    public function handle(int $id, array $data, ?User $actor): ItProduct
    {
        return DB::transaction(function () use ($id, $data, $actor) {
            $product = ItProduct::query()->lockForUpdate()->findOrFail($id);
            $product->update($data);
            if ($product->wasChanged()) {
                $this->notifications->handle($actor, 'Product #'.$product->id.' has been updated.',
                    'Product Updated', ['it.products.index']);
            }

            return $product;
        });
    }
}
