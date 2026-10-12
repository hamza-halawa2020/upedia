<?php

namespace Modules\Marketing\Reports\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Marketing\Reports\Http\Requests\MarketingReportRequest;
use Modules\Marketing\Reports\Services\MarketingReportService;

class MarketingReportController extends Controller
{
    public function __construct(private readonly MarketingReportService $reports)
    {
        $this->middleware('check.permission:marketing_reports_index')->only('index');
    }

    public function index(MarketingReportRequest $request)
    {
        return view('marketing::reports.index', $this->reports->build($request->validated()));
    }
}
