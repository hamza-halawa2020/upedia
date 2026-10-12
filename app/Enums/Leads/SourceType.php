<?php

namespace App\Enums\Leads;

enum SourceType: string
{
    case WEBSITE = 'website';
    case REFERRAL = 'referral';
    case ADS = 'ads';
    case FACEBOOK = 'facebook';
    case WHATSAPP = 'whatsapp';
    case INSTAGRAM = 'instagram';
    case X = 'x';
    case SNAPCHAT = 'snapchat';
}
