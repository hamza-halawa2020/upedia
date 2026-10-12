<?php

namespace Modules\Marketing\Complaints\Http\Controllers;

use App\Models\Complain;
use App\Support\Api\ApiResponse;
use Illuminate\Routing\Controller;
use Modules\Marketing\Complaints\Actions\CreateComplaint;
use Modules\Marketing\Complaints\Actions\DeleteComplaint;
use Modules\Marketing\Complaints\Actions\UpdateComplaint;
use Modules\Marketing\Complaints\Http\Requests\CheckLeadPhoneRequest;
use Modules\Marketing\Complaints\Http\Requests\ComplaintRequest;
use Modules\Marketing\Complaints\Http\Requests\ListComplaintsRequest;
use Modules\Marketing\Complaints\Queries\FindClientMatches;
use Modules\Marketing\Complaints\Queries\FindComplaint;
use Modules\Marketing\Complaints\Queries\ListComplaints;
use Modules\Marketing\Complaints\Queries\ListSalesStaff;

class ComplaintController extends Controller
{
    public function index(ListComplaintsRequest $request, ListComplaints $listComplaints, ListSalesStaff $listSalesStaff)
    {
        return view('marketing::complaints.index', [
            'complains' => $listComplaints->handle($request->validated()),
            'salesStaff' => $listSalesStaff->handle(),
        ]);
    }

    public function create(ListSalesStaff $listSalesStaff)
    {
        return view('marketing::complaints.create', [
            'salesStaff' => $listSalesStaff->handle(),
        ]);
    }

    public function store(ComplaintRequest $request, CreateComplaint $createComplaint)
    {
        try {
            $createComplaint->handle($request->validated());

            return $request->expectsJson()
                ? ApiResponse::success(['redirect' => route('complains.index')], 'Complain created successfully.')
                : redirect()->route('complains.index')->with('success', 'Complain created successfully.');
        } catch (\Throwable $exception) {
            return $this->failed($request, $exception);
        }
    }

    public function show(Complain $complain, FindComplaint $findComplaint)
    {
        return view('marketing::complaints.show', [
            'complain' => $findComplaint->handle($complain),
        ]);
    }

    public function edit(Complain $complain, FindComplaint $findComplaint, ListSalesStaff $listSalesStaff)
    {
        return view('marketing::complaints.edit', [
            'complain' => $findComplaint->handle($complain),
            'salesStaff' => $listSalesStaff->handle(),
        ]);
    }

    public function update(ComplaintRequest $request, Complain $complain, UpdateComplaint $updateComplaint)
    {
        try {
            $updateComplaint->handle($complain, $request->validated());

            return $request->expectsJson()
                ? ApiResponse::success(['redirect' => route('complains.index')], 'Complain updated successfully.')
                : redirect()->route('complains.index')->with('success', 'Complain updated successfully.');
        } catch (\Throwable $exception) {
            return $this->failed($request, $exception);
        }
    }

    public function destroy(Complain $complain, DeleteComplaint $deleteComplaint)
    {
        $deleteComplaint->handle($complain);

        return redirect()->route('complains.index')->with('success', 'Complain deleted successfully.');
    }

    public function checkLeads(CheckLeadPhoneRequest $request, FindClientMatches $findClientMatches)
    {
        $matches = $findClientMatches->handle($request->validated('client_number'));
        $first = $matches->first();

        return ApiResponse::success([
            'exists' => $matches->isNotEmpty(),
            'client_name' => $first['client_name'] ?? null,
            'client_number' => $first['phone'] ?? null,
            'matches' => $matches,
        ]);
    }

    private function failed($request, \Throwable $exception)
    {
        return $request->expectsJson()
            ? ApiResponse::error($exception->getMessage(), [], 422)
            : back()->withInput()->with('error', $exception->getMessage());
    }
}
