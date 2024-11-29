<?php

namespace App\Enumerators;

enum UserStatus: string
{
    case NOT_SCHEDULED = 'Not scheduled';
    case SCHEDULED = 'Scheduled';
    case VACCINATED = 'Vaccinated';
}
