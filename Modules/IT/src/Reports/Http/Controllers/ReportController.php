<?php

namespace Modules\IT\Reports\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\IT\Reports\Http\Requests\ReportRequest;
use Modules\IT\Reports\Queries\BuildReport;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_reports_index');
    }

    public function index(ReportRequest $request, BuildReport $report)
    {
        return view('it::reports.index', $report->handle($request->validated()));
    }
}
