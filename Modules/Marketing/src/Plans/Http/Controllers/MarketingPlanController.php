<?php

namespace Modules\Marketing\Plans\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Marketing\Plans\Actions\CreateMarketingPlan;
use Modules\Marketing\Plans\Actions\DeleteMarketingPlan;
use Modules\Marketing\Plans\Actions\UpdateMarketingPlan;
use Modules\Marketing\Plans\Exports\MarketingPlansExport;
use Modules\Marketing\Plans\Http\Requests\CalendarEventsRequest;
use Modules\Marketing\Plans\Http\Requests\ListMarketingPlansRequest;
use Modules\Marketing\Plans\Http\Requests\MarketingPlanRequest;
use Modules\Marketing\Plans\Queries\FindMarketingPlan;
use Modules\Marketing\Plans\Queries\ListCalendarEvents;
use Modules\Marketing\Plans\Queries\ListMarketingPlans;
use Modules\Marketing\Plans\Queries\ListPublishedMonths;

class MarketingPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:marketing_plans_index')->only(['index']);
        $this->middleware('check.permission:marketing_plans_create')->only(['create', 'store']);
        $this->middleware('check.permission:marketing_plans_show')->only(['show']);
        $this->middleware('check.permission:marketing_plans_destroy')->only(['destroy']);
    }

    public function index(ListMarketingPlansRequest $request, ListMarketingPlans $plans)
    {
        return view('marketing::plans.index', [
            'plans' => $plans->paginate($request->criteria(), Auth::user()),
        ]);
    }

    public function create()
    {
        return view('marketing::plans.create', ['staff' => Auth::user()->staff]);
    }

    public function store(MarketingPlanRequest $request, CreateMarketingPlan $create): RedirectResponse
    {
        $create->handle($request->payload(), $request->file('attachments'));

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function show(int $plan, FindMarketingPlan $find)
    {
        return view('marketing::plans.show', ['plan' => $find->handle($plan)]);
    }

    public function edit(int $plan, FindMarketingPlan $find)
    {
        return view('marketing::plans.edit', [
            'plan' => $find->handle($plan),
            'staff' => Auth::user()->staff,
        ]);
    }

    public function update(int $plan, MarketingPlanRequest $request, UpdateMarketingPlan $update): RedirectResponse
    {
        $updatedPlan = $update->handle($plan, $request->payload(), $request->file('attachments'));

        return redirect()->route('plans.show', $updatedPlan->id)->with('success', 'Plan updated successfully.');
    }

    public function destroy(int $plan, DeleteMarketingPlan $delete): RedirectResponse
    {
        $delete->handle($plan);

        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }

    public function months(ListPublishedMonths $months)
    {
        return view('marketing::plans.months', ['months' => $months->handle()]);
    }

    public function calendar()
    {
        return view('marketing::plans.calendar');
    }

    public function calendarEvents(CalendarEventsRequest $request, ListCalendarEvents $events)
    {
        return response()->json($events->handle($request->criteria()));
    }

    public function export(ListMarketingPlansRequest $request, ListMarketingPlans $plans)
    {
        $filename = 'marketing_plans.xlsx';
        $items = $plans->collection($request->criteria(), Auth::user());

        return Excel::download(new MarketingPlansExport($items), $filename);
    }
}

