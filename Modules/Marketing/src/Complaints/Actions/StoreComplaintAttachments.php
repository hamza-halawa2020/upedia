<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;

class StoreComplaintAttachments
{
    public function handle(Complain $complain, ?array $files): void
    {
        if (!$files) {
            return;
        }

        $destination = public_path('uploads/complains');

        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        foreach ($files as $file) {
            if (!$file->isValid()) {
                continue;
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destination, $fileName);

            $complain->attachments()->create([
                'file_path' => 'uploads/complains/' . $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
            ]);
        }
    }
}
