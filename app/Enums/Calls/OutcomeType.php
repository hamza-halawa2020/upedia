<?php

namespace App\Enums\Calls;

enum OutcomeType: string
{
    case INTERESTED = 'interested';
    case NOT_INTERESTED = 'not_interested';
    case RESCHEDULE = 'reschedule';
    case NOT_ANSWERED = 'not_answered';
    case WRONG_NUMBER = 'wrong_number';
    case PENDING = 'pending';
}
