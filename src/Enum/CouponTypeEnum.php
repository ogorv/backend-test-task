<?php

declare(strict_types=1);

namespace App\Enum;

enum CouponTypeEnum: string
{
    case PERCENTAGE = 'percentage';
    case FIXED      = 'fixed';
}
