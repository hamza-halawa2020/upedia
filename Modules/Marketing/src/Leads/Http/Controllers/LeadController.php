<?php

namespace Modules\Marketing\Leads\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Services\LeadService;

class LeadController extends \Illuminate\Routing\Controller
{
    protected $leadService;
    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
        $this->middleware('check.permission:crm_leads-create')->only(['addLead']);
        $this->middleware('check.permission:crm_leads-store')->only(['storeLead']);
    }

    public function addLead()
    {
        return view('marketing::leads.add_lead');
    }

    public function storeLead(LeadRequest $request)
    {
        $this->leadService->storeLead($request->validated());
        return redirect()->route('addLead')->with('success', 'Lead added successfully.');
    }
}
