<?php

namespace Modules\Marketing\Reports\Queries;

use App\Models\Complain;
use App\Models\Lead;
use App\Models\MarketingPlan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;


class ReportData
{
    public function getPlans(Carbon $from, Carbon $to): Collection
    {
        if (!Schema::hasTable((new MarketingPlan())->getTable())) {
            return collect();
        }

        return MarketingPlan::query()
            ->with('staff:id,first_name,last_name,full_name')
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('publish_date', [$from->toDateString(), $to->toDateString()])
                    ->orWhere(function ($nested) use ($from, $to) {
                        $nested->whereNull('publish_date')
                            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()]);
                    });
            })
            ->get();
    }

    public function getComplains(Carbon $from, Carbon $to): Collection
    {
        if (!Schema::hasTable((new Complain())->getTable())) {
            return collect();
        }

        return Complain::query()
            ->with([
                'staff:id,first_name,last_name,full_name',
                'sales:id,first_name,last_name,full_name',
                'solver:id,full_name',
            ])
            ->where(function ($query) use ($from, $to) {
                $query->whereBetween('date', [$from->toDateString(), $to->toDateString()])
                    ->orWhereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()]);
            })
            ->get();
    }

    public function getLeads(Carbon $from, Carbon $to): Collection
    {
        $lead = new Lead();

        if (!Schema::hasTable($lead->getTable()) || !Schema::hasColumn($lead->getTable(), 'created_at')) {
            return collect();
        }

        return Lead::query()
            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->get();
    }
}
