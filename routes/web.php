<?php

use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\RoleController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserRolePermissionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\TabController;

// Login routes (accessible only by guests)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('sso.token')->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});
Route::middleware(['sso.token','auth'])->group(function () {
    Route::get('/systems', [ProjectController::class, 'settings'])->name('settings');
    Route::get('/', [ProjectController::class, 'index'])->name('dashboard');
    Route::post('fcm-token', [LoginController::class, 'fcmToken'])->name('fcm.token');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/sso/consume/{user}', [LoginController::class, 'consumeIframeSessionLink'])->middleware('signed')->name('sso.consume');

Route::middleware(['sso.token'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('user-role-permissions', UserRolePermissionController::class);

    Route::resource('departments', DepartmentController::class);
    Route::get('tabs/template', [TabController::class, 'exportTemplate'])->name('tabs.template');
    Route::get('tabs/export', [TabController::class, 'export'])->name('tabs.export');
    Route::post('tabs/import', [TabController::class, 'import'])->name('tabs.import');
    Route::resource('tabs', TabController::class);

});
