<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken as Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ValidateCsrfToken extends Middleware
{
    protected function tokensMatch($request): bool
    {
        if ($this->hasValidIframeToken($request)) {
            return true;
        }

        return parent::tokensMatch($request);
    }

    private function hasValidIframeToken(Request $request): bool
    {
        $plainToken = $this->resolveToken($request);

        if ($plainToken === '') {
            return false;
        }

        $token = PersonalAccessToken::findToken($plainToken);

        if (! $token || ! $token->tokenable) {
            return false;
        }

        return $token->can('iframe-access');
    }

    private function resolveToken(Request $request): string
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
            parse_str((string) data_get(parse_url($referer), 'query', ''), $query);
            return (string) ($query['sso_token'] ?? '');
        }

        return '';
    }
}
