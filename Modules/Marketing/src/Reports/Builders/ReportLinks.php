<?php

namespace Modules\Marketing\Reports\Builders;

use Carbon\Carbon;


class ReportLinks
{
    public function plansUrl(array $params = []): string
    {
        return route('plans.index', $this->cleanParams($params));
    }

    public function complainsUrl(array $params = []): string
    {
        return route('complains.index', $this->cleanParams($params));
    }

    public function leadsUrl(array $params = []): string
    {
        $base = rtrim((string) config('app.CRM_URL'), '/');

        if ($base === '') {
            return route('dashboard');
        }

        $query = http_build_query($this->cleanParams($params));

        return $base . '/leads' . ($query ? ('?' . $query) : '');
    }

    public function cleanParams(array $params): array
    {
        return collect($params)
            ->reject(fn ($value) => $value === null || $value === '')
            ->all();
    }
}
