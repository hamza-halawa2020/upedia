<?php

namespace App\Enums\WorkFlow;

enum ActionType: string
{
    case reschedule_call = 'reschedule_call';
    case not_interested_reasons = 'not_interested_reasons';
}
