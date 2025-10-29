<?php

declare(strict_types=1);

namespace App\Enum;

enum PurchaseStatusEnum: string
{
    case NEW = 'new';
    case PAID = 'paid';
}
