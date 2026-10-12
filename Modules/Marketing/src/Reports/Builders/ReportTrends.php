<?php

namespace Modules\Marketing\Reports\Builders;

use Carbon\Carbon;
use Illuminate\Support\Collection;


class ReportTrends
{
    public function __construct(
        private readonly ReportMetrics $metrics,
        private readonly ReportLinks $links
    ) {}

    public function build(Collection $plans, Collection $complains, Collection $leads, Carbon $from, Carbon $to, array $summary): array
    {
        $planTrend = $this->metrics->countByDateRange(
            $plans,
            $from,
            $to,
            fn ($plan) => $plan->publish_date ?: optional($plan->created_at)->toDateString(),
            fn ($date) => $this->links->plansUrl(['start_date' => $date, 'end_date' => $date])
        );

        $complainTrend = $this->metrics->countByDateRange(
            $complains,
            $from,
            $to,
            function ($complain) use ($from, $to) {
                if ($complain->date) {
                    $date = Carbon::parse($complain->date);

                    if ($date->betweenIncluded($from, $to)) {
                        return $date->toDateString();
                    }
                }

                return optional($complain->created_at)->toDateString();
            },
            fn ($date) => $this->links->complainsUrl(['start_date' => $date, 'end_date' => $date])
        );

        $leadTrend = $this->metrics->countByDateRange(
            $leads,
            $from,
            $to,
            fn ($lead) => optional($lead->created_at)->toDateString(),
            fn () => $this->links->leadsUrl()
        );

        $planOwners = $this->metrics->topStaff(
            $plans,
            fn ($plan) => $plan->staff,
            5,
            fn ($staffId) => $this->links->plansUrl([
                'created_by' => $staffId,
                'start_date' => $from->toDateString(),
                'end_date' => $to->toDateString(),
            ])
        );

        $complainOwners = $this->metrics->topStaff(
            $complains,
            fn ($complain) => $complain->staff,
            5,
            fn ($staffId) => $this->links->complainsUrl([
                'creator_id' => $staffId,
                'start_date' => $from->toDateString(),
                'end_date' => $to->toDateString(),
            ])
        );

        $salesOwners = $this->metrics->topStaff(
            $complains,
            fn ($complain) => $complain->sales,
            5,
            fn ($staffId) => $this->links->complainsUrl([
                'staff_id' => $staffId,
                'start_date' => $from->toDateString(),
                'end_date' => $to->toDateString(),
            ])
        );

        return compact('planTrend', 'complainTrend', 'leadTrend', 'planOwners', 'complainOwners', 'salesOwners');
    }
}
