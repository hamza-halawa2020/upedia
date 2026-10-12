<?php

use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\Cors;
use App\Http\Middleware\SsoTokenAuthenticate;
use App\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserIsActive;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(replace: [
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class => ValidateCsrfToken::class,
        ]);

        $middleware->web(append: [
            SsoTokenAuthenticate::class,
        ]);

        $middleware->priority([
            SsoTokenAuthenticate::class,
            Authenticate::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            $token = (string) $request->query('sso_token', '');

            if ($token === '') {
                $referer = (string) $request->headers->get('referer', '');
                if ($referer !== '') {
                    parse_str((string) data_get(parse_url($referer), 'query', ''), $query);
                    $token = (string) ($query['sso_token'] ?? '');
                }
            }

            return $token !== '' ? route('auth.login', ['sso_token' => $token]) : route('auth.login');
        });

        $middleware->redirectUsersTo(function (Request $request) {
            $token = (string) $request->query('sso_token', '');

            if ($token === '') {
                $referer = (string) $request->headers->get('referer', '');
                if ($referer !== '') {
                    parse_str((string) data_get(parse_url($referer), 'query', ''), $query);
                    $token = (string) ($query['sso_token'] ?? '');
                }
            }

            return $token !== '' ? route('dashboard', ['sso_token' => $token]) : route('dashboard');
        });

        $middleware->alias([
            'user.active' => EnsureUserIsActive::class,
            'check.permission' => CheckPermission::class,
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
            'cors' => Cors::class,
            'sso.token' => SsoTokenAuthenticate::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
