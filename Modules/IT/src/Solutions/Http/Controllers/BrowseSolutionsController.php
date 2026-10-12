<?php

namespace Modules\IT\Solutions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\IT\Solutions\Http\Requests\BrowseSolutionsRequest;
use Modules\IT\Solutions\Queries\VisibleSolutions;

class BrowseSolutionsController extends Controller
{
    public function index(BrowseSolutionsRequest $request, VisibleSolutions $solutions)
    {
        return view('it::solutions.browse', ['solutions' => $solutions->list($request->user(), $request->validated())]);
    }

    public function show(Request $request, int $id, VisibleSolutions $solutions)
    {
        return view('it::solutions.view', ['solution' => $solutions->find($request->user(), $id)]);
    }
}
