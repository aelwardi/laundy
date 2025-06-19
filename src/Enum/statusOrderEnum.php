<?php

declare(strict_types=1);
namespace App\Enum;

enum statusOrderEnum: string {
    case CREATED = 'created';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
    case COLLECTED = 'collected';
    case PAYED = 'paid';
    case DELIVERED = 'delivered';
    case COMPLETED = 'completed';
}
