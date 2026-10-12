<?php

namespace Modules\Marketing\Plans\Actions;

use App\Models\MarketingPlan;

class StoreMarketingPlanAttachments
{
    public function handle(MarketingPlan $plan, mixed $files): void
    {
        if (! $files || count($files) === 0) {
            return;
        }

        foreach ($files as $file) {
            if (! $file->isValid()) {
                continue;
            }

            $fileName = time().'_'.$file->getClientOriginalName();
            $destination = public_path('uploads/marketing-plans');

            if (! file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            file_put_contents($destination.'/'.$fileName, file_get_contents($file->getRealPath()));

            $plan->attachments()->create([
                'file_path' => 'uploads/marketing-plans/'.$fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
            ]);
        }
    }
}

