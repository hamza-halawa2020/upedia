<?php

namespace Tests\Feature;

use App\Http\Middleware\SsoTokenAuthenticate;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RestrictedModuleRoutesTest extends TestCase
{
    public function test_every_permission_guarded_domain_endpoint_rejects_an_ungranted_user(): void
    {
        $this->withoutMiddleware(SsoTokenAuthenticate::class);
        $this->actingAs(User::create([
            'full_name' => 'Restricted', 'email' => 'no-grants@example.test', 'password' => bcrypt('test'),
        ]));
        $endpoints = [];
        foreach (Route::getRoutes() as $route) {
            if (! preg_match('#^(it|marketing)(/|$)#', $route->uri())) {
                continue;
            }
            $guards = array_filter($route->gatherMiddleware(), fn ($middleware) => is_string($middleware)
                && str_starts_with($middleware, 'check.permission:'));
            if (! $guards) {
                continue;
            }
            foreach ($guards as $guard) {
                foreach (explode(',', substr($guard, strlen('check.permission:'))) as $name) {
                    Permission::findOrCreate($name, 'web');
                }
            }
            $uri = '/'.preg_replace('/\{[^}]+\}/', '1', $route->uri());
            foreach (array_diff($route->methods(), ['HEAD']) as $method) {
                $endpoints[] = [$method, $uri];
            }
        }
        $this->assertNotEmpty($endpoints);
        foreach ($endpoints as [$method, $uri]) {
            $this->call($method, $uri)->assertForbidden();
        }
    }
}
