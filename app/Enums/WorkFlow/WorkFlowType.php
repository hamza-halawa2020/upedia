<?php

namespace App\Enums\WorkFlow;

enum WorkFlowType: string
{
    case Lead = 'lead';
    case CALL = 'call';
    case TEST = 'test';
}
