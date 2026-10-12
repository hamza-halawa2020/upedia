<?php

namespace Modules\IT\Vendors\Actions;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Modules\Notifications\Actions\NotifyActor;

class UpdateVendor
{
    public function __construct(private readonly NotifyActor $notifications) {}

    public function handle(int $id, array $data, ?User $actor): Vendor
    {
        return DB::transaction(function () use ($id, $data, $actor) {
            $vendor = Vendor::lockForUpdate()->findOrFail($id);
            $vendor->update($data);
            if ($vendor->wasChanged()) {
                $this->notifications->handle($actor, 'Vendor #'.$vendor->id.' has been updated.',
                    'Vendor Updated', ['it.vendors.index']);
            }

            return $vendor;
        });
    }
}
