<?php

namespace Modules\IT\Dashboard\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\IT\Dashboard\Queries\AssetOverview;
use Modules\IT\Dashboard\Queries\TicketOverview;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_dashboard_index')->only(['index', 'requestsDashboard']);
        $this->middleware('check.permission:it_assets_index')->only('assetDashboard');
    }

    public function index()
    {
        return view('it::dashboard.index');
    }

    public function requestsDashboard(TicketOverview $tickets)
    {
        return view('it::dashboard.statistics', $tickets->handle());
    }

    public function assetDashboard(AssetOverview $assets)
    {
        return view('it::dashboard.assets', $assets->handle());
    }
}
