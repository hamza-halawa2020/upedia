<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\LoginController;

Route::post('/sso/token-link', [LoginController::class, 'createIframeTokenLink'])->middleware('throttle:20,1')->name('api.sso.token-link');
