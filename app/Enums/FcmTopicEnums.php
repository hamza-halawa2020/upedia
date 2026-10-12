<?php

namespace App\Enums;

enum FcmTopicEnums: string
{
    case Super_Admins = 'Super admin';
    case Agent_Managers = 'Agent Manager';
    case Agents = 'Agent';
    case Moderations = 'Moderation';
}
