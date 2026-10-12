<?php

namespace Modules\Marketing\QuickLinks\Http\Controllers;

use App\Models\QuickLink;
use App\Support\Api\ApiResponse;
use Illuminate\Routing\Controller;
use Modules\Marketing\QuickLinks\Actions\CreateQuickLink;
use Modules\Marketing\QuickLinks\Actions\DeleteQuickLink;
use Modules\Marketing\QuickLinks\Actions\UpdateQuickLink;
use Modules\Marketing\QuickLinks\Http\Requests\QuickLinkRequest;
use App\Queries\ListDepartments;
use Modules\Marketing\QuickLinks\Queries\ListQuickLinks;

class QuickLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:marketing_quickLinks_index')->only('index');
        $this->middleware('check.permission:marketing_quickLinks_create')->only(['store', 'update']);
        $this->middleware('check.permission:marketing_quickLinks_destroy')->only('destroy');
    }

    public function index(ListQuickLinks $quickLinks, ListDepartments $departments)
    {
        return view('marketing::quick-links.index', [
            'quickLinks' => $quickLinks->handle(),
            'departments' => $departments->handle(),
        ]);
    }

    public function store(QuickLinkRequest $request, CreateQuickLink $createQuickLink)
    {
        $quickLink = $createQuickLink->handle($request->validated());

        return ApiResponse::success([
            'quickLink' => $quickLink,
        ], 'Quick link created successfully');
    }

    public function update(QuickLinkRequest $request, QuickLink $quickLink, UpdateQuickLink $updateQuickLink)
    {
        $quickLink = $updateQuickLink->handle($quickLink, $request->validated());

        return ApiResponse::success([
            'quickLink' => $quickLink,
        ], 'Quick link updated successfully');
    }

    public function destroy(QuickLink $quickLink, DeleteQuickLink $deleteQuickLink)
    {
        $deleteQuickLink->handle($quickLink);

        return ApiResponse::success(message: 'Quick link deleted successfully');
    }
}
