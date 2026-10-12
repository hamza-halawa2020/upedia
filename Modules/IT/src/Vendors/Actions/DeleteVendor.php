<?php

namespace Modules\IT\Vendors\Actions;

use App\Models\Asset;
use App\Models\AssetAccessory;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Modules\Notifications\Actions\NotifyActor;

class DeleteVendor
{
    public function __construct(private readonly NotifyActor $notifications) {}

    public function handle(int $id, ?User $actor): void
    {
        DB::transaction(function () use ($id, $actor) {
            $vendor = Vendor::lockForUpdate()->findOrFail($id);
            $assets = Asset::where('vendor_id', $vendor->id);
            AssetAccessory::whereIn('asset_id', (clone $assets)->select('id'))->delete();
            $assets->delete();
            $vendor->delete();
            $this->notifications->handle($actor, 'Vendor #'.$id.' has been deleted.',
                'Vendor Deleted', ['it.vendors.index']);
        });
    }
}
