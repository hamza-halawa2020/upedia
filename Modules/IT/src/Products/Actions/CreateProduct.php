<?php

namespace Modules\IT\Products\Actions;

use App\Models\ItProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Notifications\Actions\NotifyActor;

class CreateProduct
{
    public function __construct(private readonly NotifyActor $notifications) {}

    public function handle(array $data, ?User $actor): ItProduct
    {
        return DB::transaction(function () use ($data, $actor) {
            $product = ItProduct::create($data);
            $this->notifications->handle($actor, 'Product #'.$product->id.' has been created.',
                'Product Created', ['it.products.index']);

            return $product;
        });
    }
}
