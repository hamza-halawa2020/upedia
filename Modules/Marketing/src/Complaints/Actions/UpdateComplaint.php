<?php

namespace Modules\Marketing\Complaints\Actions;

use App\Models\Complain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateComplaint
{
    public function __construct(
        private readonly ResolveClientName $resolveClientName,
        private readonly DeleteComplaintAttachments $deleteAttachments,
        private readonly StoreComplaintAttachments $storeAttachments,
    ) {
    }

    public function handle(Complain $complain, array $data): Complain
    {
        return DB::transaction(function () use ($complain, $data) {
            $attachments = $data['attachments'] ?? null;
            unset($data['attachments']);

            $complain->update($this->prepareData($data));

            if ($attachments !== null) {
                $this->deleteAttachments->handle($complain);
                $this->storeAttachments->handle($complain, $attachments);
            }

            return $complain;
        });
    }

    private function prepareData(array $data): array
    {
        if (empty($data['client_name'])) {
            $data['client_name'] = $this->resolveClientName->handle($data['client_number'])
                ?? throw new \RuntimeException('Client with this number does not exist.');
        }

        $data['solved_by'] = ($data['status'] ?? null) === 'solved' ? Auth::id() : null;

        return $data;
    }
}
