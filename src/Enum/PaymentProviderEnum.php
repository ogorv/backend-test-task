<?php

declare(strict_types=1);

namespace App\Enum;

enum PaymentProviderEnum: string
{
    use GettingValuesTrait;

    case PAYPAL = 'paypal';

    case STRIPE = 'stripe';
}
