<?php

namespace Modules\Marketing\Reports\Http\Controllers;

use App\Services\MarketingReportService;
use Illuminate\Http\Request;

class MarketingReportController extends \Illuminate\Routing\Controller
{
    protected $reportService;

    public function __construct(MarketingReportService $reportService)
    {
        $this->reportService = $reportService;
        $this->middleware('check.permission:marketing_reports_index')->only(['index']);

    }

    public function index(Request $request)
    {
        $dashboard = $this->reportService->build($request->only(['from', 'to']));

        return view('marketing::reports.index', $dashboard);
    }
}
