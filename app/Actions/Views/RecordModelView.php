<?php

namespace App\Actions\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordModelView
{
    public function handle(Model $model, Request $request): void
    {
        DB::transaction(function () use ($model, $request) {
            $model->recordView($request->user()?->id, $request->ip(), $request->userAgent());
        });
    }
}
