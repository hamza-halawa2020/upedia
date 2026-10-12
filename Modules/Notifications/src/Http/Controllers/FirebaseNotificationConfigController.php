<?php

namespace Modules\Notifications\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Notifications\Actions\SaveFirebaseConfig;
use Modules\Notifications\Http\Requests\FirebaseConfigRequest;
use Modules\Notifications\Queries\FirebaseConfig;

class FirebaseNotificationConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:notifications_config_manage');
    }

    public function index(FirebaseConfig $config)
    {
        return view('notifications::firebase-configs.index', ['config' => $config->handle()]);
    }

    public function store(FirebaseConfigRequest $request, SaveFirebaseConfig $save)
    {
        $save->handle($request->validated());

        return redirect()->route('firebase-configs.index')->with('success', 'Configuration updated.');
    }
}
