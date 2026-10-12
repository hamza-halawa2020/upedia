<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateComplaint
{
    public function __construct(
        private readonly ResolveClientName $resolveClientName,
        private readonly StoreComplaintAttachments $storeAttachments,
    ) {
    }

    public function handle(array $data): Complain
    {
        return DB::transaction(function () use ($data) {
            $attachments = $data['attachments'] ?? null;
            unset($data['attachments']);

            $data = $this->fillClientName($data);
            $data = $this->applyStatusMetadata($data);

            $complain = Complain::create($data);
            $this->storeAttachments->handle($complain, $attachments);

            return $complain;
        });
    }

    private function fillClientName(array $data): array
    {
        if (!empty($data['client_name'])) {
            return $data;
        }

        $data['client_name'] = $this->resolveClientName->handle($data['client_number'])
            ?? throw new \RuntimeException('Client with this number does not exist.');

        return $data;
    }

    private function applyStatusMetadata(array $data): array
    {
        $data['solved_by'] = ($data['status'] ?? null) === 'solved' ? Auth::id() : null;

        return $data;
    }
}
