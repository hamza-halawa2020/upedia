<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\PersonalAccessToken;

class SsoTokenAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $plainToken = $this->resolveSsoToken($request);

        if (! Auth::check()) {
            if ($plainToken !== '') {
                $token = PersonalAccessToken::findToken($plainToken);

                if ($token && $token->tokenable) {
                    Auth::login($token->tokenable);

                    if ($request->hasSession()) {
                        $request->session()->regenerate();
                        $request->session()->put('user_id', $token->tokenable->id);
                        $request->session()->save();
                    }

                    URL::defaults(['sso_token' => $plainToken]);
                }
            }
        } elseif ($plainToken !== '') {
            URL::defaults(['sso_token' => $plainToken]);
        }

        return $next($request);
    }

    private function resolveSsoToken(Request $request): string
    {
        $token = (string) $request->query('sso_token', '');

        if ($token !== '') {
            return $token;
        }

        $token = (string) $request->input('sso_token', '');

        if ($token !== '') {
            return $token;
        }

        $token = (string) $request->bearerToken();

        if ($token !== '') {
            return $token;
        }

        $referer = (string) $request->headers->get('referer', '');

        if ($referer !== '') {
            $refererToken = (string) data_get(parse_url($referer), 'query', '');
            parse_str($refererToken, $refererQuery);
            return (string) ($refererQuery['sso_token'] ?? '');
        }

        return '';
    }
}
