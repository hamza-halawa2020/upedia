<?php

namespace App\Queries\Readiness;

use Illuminate\Support\Facades\Route;

class RequiredModulePermissions
{
    public function handle(): array
    {
        $permissions = [];
        foreach (Route::getRoutes() as $route) {
            if (! preg_match('#^(marketing|it)(/|$)|^firebase-configs$#', $route->uri())) {
                continue;
            }
            foreach ($route->gatherMiddleware() as $middleware) {
                if (preg_match('/^check\.(?:any\.)?permission:(.+)$/', $middleware, $match)) {
                    foreach (explode(',', $match[1]) as $permission) {
                        $permissions[] = $permission;
                    }
                }
            }
        }
        $permissions = array_values(array_unique($permissions));
        sort($permissions);

        return $permissions;
    }
}
