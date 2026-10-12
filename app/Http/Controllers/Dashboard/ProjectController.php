<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController  extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function settings()
    {
        $projects = collect(config('projects'))->filter(function ($project) {
            return empty($project['hidden']);
        });
        return view('dashboard.dashboard', compact('projects'));
    }
}