<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MigratedRouteCoverageTest extends TestCase
{
    public function test_source_business_resources_are_registered_with_resolvable_actions(): void
    {
        foreach (['purchase', 'expenses', 'asset', 'tickets', 'ticket-items', 'ticket-categories', 'ticket-priorities',
            'vendors', 'products', 'it-solutions'] as $resource) {
            $this->resource('it/'.$resource);
        }
        foreach (['plans', 'scripts', 'complains'] as $resource) {
            $this->resource('marketing/'.$resource);
        }
    }

    public function test_source_special_endpoints_are_registered_before_resource_wildcards(): void
    {
        $get = [
            'it', 'it/statistics', 'it/asset-dashboard', 'it/reports', 'it/filtered-tables',
            'it/filtered-tables/{record}/restore', 'it/filtered-tables/{record}/view',
            'it/solutions', 'it/solutions/{record}', 'it/tickets/staff-by-department/{record}',
            'it/tickets/staff-search', 'it/tickets/staff-details/{record}',
            'marketing', 'marketing/reports', 'marketing/get-months', 'marketing/calendar',
            'marketing/plans/calendar/events', 'marketing/plans/export', 'marketing/scripts/export',
            'marketing/leads/check', 'marketing/quick-links', 'firebase-configs', 'notifications',
        ];
        foreach (['purchase', 'expenses', 'asset', 'tickets', 'vendors'] as $resource) {
            $get[] = 'it/'.$resource.'/export';
            $get[] = 'it/'.$resource.'/save-filtered-table';
        }
        foreach ($get as $uri) {
            $this->endpoint('GET', $uri);
        }
        foreach (['it/updateStatus', 'it/updateStatus/purchase', 'marketing/quick-links', 'firebase-configs',
            'notifications/token', 'notifications/mark-all-read', 'notifications/{record}/mark-as-read'] as $uri) {
            $this->endpoint('POST', $uri);
        }
        $this->endpoint('PUT', 'marketing/quick-links/{record}');
        $this->endpoint('DELETE', 'marketing/quick-links/{record}');
        $this->endpoint('DELETE', 'it/filtered-tables/{record}');
    }

    public function test_module_routes_have_no_duplicate_method_uri_pairs(): void
    {
        $seen = [];
        foreach (Route::getRoutes() as $route) {
            if (! preg_match('#^(it|marketing)(/|$)#', $route->uri())) {
                continue;
            }
            foreach ($route->methods() as $method) {
                $key = $method.' '.$this->normalize($route->uri());
                $this->assertArrayNotHasKey($key, $seen, 'Duplicate route: '.$key);
                $seen[$key] = true;
            }
        }
        $this->assertNotEmpty($seen);
    }

    private function resource(string $uri): void
    {
        foreach ([['GET', ''], ['GET', '/create'], ['POST', ''], ['GET', '/{record}'],
            ['GET', '/{record}/edit'], ['PUT', '/{record}'], ['PATCH', '/{record}'], ['DELETE', '/{record}']] as [$method, $suffix]) {
            $this->endpoint($method, $uri.$suffix);
        }
    }

    private function endpoint(string $method, string $uri): void
    {
        $matches = collect(Route::getRoutes())->filter(fn ($route) => in_array($method, $route->methods(), true)
            && $this->normalize($route->uri()) === $this->normalize($uri));
        $this->assertCount(1, $matches, 'Missing/duplicate endpoint: '.$method.' '.$uri);
        $route = $matches->first();
        $this->assertNotNull($route->getName());
        if ($route->getActionName() !== 'Closure') {
            [$controller, $action] = array_pad(explode('@', $route->getActionName()), 2, '__invoke');
            $this->assertTrue(method_exists($controller, $action), 'Unresolved action: '.$route->getActionName());
        }
        if (! str_contains($uri, '{')) {
            $matched = Route::getRoutes()->match(\Illuminate\Http\Request::create('/'.$uri, $method));
            $this->assertSame($route->getName(), $matched->getName(), 'Wildcard shadows: '.$uri);
        }
    }

    private function normalize(string $uri): string
    {
        return preg_replace('/\{[^}]+\}/', '{record}', trim($uri, '/'));
    }
}
