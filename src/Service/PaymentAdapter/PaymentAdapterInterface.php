<?php

declare(strict_types=1);

namespace App\Service\PaymentAdapter;

use App\Entity\Currency;

interface PaymentAdapterInterface
{
    /** @throws PaymentErrorException */
    public function pay(float $amount, Currency $currency): void;
}