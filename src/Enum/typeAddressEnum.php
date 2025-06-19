<?php

declare(strict_types=1);
namespace App\Enum;

enum typeAddressEnum: string {
    case HOME = 'TYPE_HOME';
    case WORK = 'TYPE_WORK';
    case HOTEL = 'TYPE_HOTEL';
}
