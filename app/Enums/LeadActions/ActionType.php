<?php

namespace App\Enums\LeadActions;

enum ActionType: string
{
    case PAYMENT = 'payment';
    case CALL = 'call';
    case TEST = 'test';
    case TASK = 'task';
    case DEMO = 'demo';
    case PRODUCT = 'product';
    case DEAL = 'deal';
    case RESCHEDULE = 'reschedule';
    case INVOICE = 'invoice';
    case SCHEDULE = 'schedule';
    case PAID_DEPOSITE = 'paid deposite';



    public static function getAllLeadActions(): array
    {
        return [
            self::PAYMENT->value,
            self::CALL->value,
            self::TEST->value,
            self::TASK->value,
            self::DEMO->value,
            self::DEAL->value,
            self::RESCHEDULE->value,
            self::INVOICE->value,
            self::SCHEDULE->value,
            self::PRODUCT->value,
            self::PAID_DEPOSITE->value,
        ];
    }


}
