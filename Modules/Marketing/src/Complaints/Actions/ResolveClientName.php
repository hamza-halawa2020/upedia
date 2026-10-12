<?php

namespace Modules\Marketing\Complaints\Actions;

use Modules\Marketing\Complaints\Queries\FindClientMatches;

class ResolveClientName
{
    public function __construct(private readonly FindClientMatches $findClientMatches)
    {
    }

    public function handle(string $phoneNumber): ?string
    {
        return $this->findClientMatches
            ->handle($phoneNumber)
            ->first()['client_name'] ?? null;
    }
}
