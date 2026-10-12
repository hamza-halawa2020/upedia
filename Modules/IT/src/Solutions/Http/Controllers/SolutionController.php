<?php

namespace Modules\IT\Solutions\Http\Controllers;

use App\Queries\ListDepartments;
use Illuminate\Routing\Controller;
use Modules\IT\Solutions\Actions\DeleteSolution;
use Modules\IT\Solutions\Actions\SaveSolution;
use Modules\IT\Solutions\Http\Requests\BrowseSolutionsRequest;
use Modules\IT\Solutions\Http\Requests\SaveSolutionRequest;
use Modules\IT\Solutions\Queries\ManageSolutions;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_solutions_index')->only('index');
        $this->middleware('check.permission:it_solutions_create')->only(['create', 'store']);
        $this->middleware('check.permission:it_solutions_show')->only('show');
        $this->middleware('check.permission:it_solutions_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_solutions_destroy')->only('destroy');
    }

    public function index(BrowseSolutionsRequest $request, ManageSolutions $query)
    {
        return view('it::solutions.admin', ['solutions' => $query->list($request->validated())]);
    }

    public function create(ListDepartments $departments)
    {
        return view('it::solutions.form', ['solution' => null, 'departments' => $departments->handle()]);
    }

    public function store(SaveSolutionRequest $request, SaveSolution $save)
    {
        $save->handle($request->validated());
        return redirect()->route('it.it-solutions.index')->with('success', 'Solution created.');
    }

    public function show(int $solution, ManageSolutions $query)
    {
        return view('it::solutions.view', ['solution' => $query->find($solution)]);
    }

    public function edit(int $solution, ManageSolutions $query, ListDepartments $departments)
    {
        return view('it::solutions.form', ['solution' => $query->find($solution), 'departments' => $departments->handle()]);
    }

    public function update(SaveSolutionRequest $request, int $solution, SaveSolution $save)
    {
        $save->handle($request->validated(), $solution);
        return redirect()->route('it.it-solutions.index')->with('success', 'Solution updated.');
    }

    public function destroy(int $solution, DeleteSolution $delete)
    {
        $delete->handle($solution);
        return redirect()->route('it.it-solutions.index')->with('success', 'Solution deleted.');
    }
}
