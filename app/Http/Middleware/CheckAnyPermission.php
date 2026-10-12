<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckAnyPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions)
    {
        foreach ($permissions as $permission) {
            if ($request->user()?->checkPermissionTo($permission)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
