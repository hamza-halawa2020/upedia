<?php

namespace Modules\IT\Vendors\Actions;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Modules\Notifications\Actions\NotifyActor;

class CreateVendor
{
    public function __construct(private readonly NotifyActor $notifications) {}

    public function handle(array $data, ?User $actor): Vendor
    {
        return DB::transaction(function () use ($data, $actor) {
            $vendor = Vendor::create($data);
            $this->notifications->handle($actor, 'Vendor #'.$vendor->id.' has been created.',
                'Vendor Created', ['it.vendors.index']);

            return $vendor;
        });
    }
}
