<?php

namespace Modules\Marketing\Complaints\Queries;

use App\Models\Complain;
use App\Models\Lead;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Marketing\Complaints\Filters\ComplaintFilters;

class ListComplaints
{
    public function handle(array $filters): LengthAwarePaginator
    {
        $query = Complain::query()
            ->with([
                'staff:id,first_name,last_name',
                'sales:id,first_name,last_name',
                'solver:id,full_name',
            ]);

        $this->applyAgentScope($query);
        (new ComplaintFilters($filters))->apply($query);

        $complaints = $query
            ->orderByDesc('id')
            ->paginate($this->perPage($filters))
            ->appends($filters);

        $this->markLeadExists($complaints->getCollection());

        return $complaints;
    }

    private function applyAgentScope($query): void
    {
        $user = auth()->user();

        if (!$user || $user->hasRole('Super admin') || $user?->staff?->jobTitle?->slug !== 'agent') {
            return;
        }

        $query->where('staff_id', $user->staff->id);
    }

    private function perPage(array $filters): int
    {
        return in_array((int) ($filters['per_page'] ?? 10), [5, 10, 25, 50, 100, 150], true)
            ? (int) ($filters['per_page'] ?? 10)
            : 10;
    }

    private function markLeadExists($complaints): void
    {
        $phones = $complaints
            ->pluck('client_number')
            ->filter()
            ->map(fn ($phone) => ltrim((string) $phone, '0'))
            ->unique()
            ->values();

        $existingPhones = Lead::query()
            ->whereIn('phone', $phones)
            ->pluck('phone')
            ->flip();

        $complaints->each(function (Complain $complain) use ($existingPhones): void {
            $complain->setAttribute(
                'lead_exists',
                $existingPhones->has(ltrim((string) $complain->client_number, '0'))
            );
        });
    }
}
