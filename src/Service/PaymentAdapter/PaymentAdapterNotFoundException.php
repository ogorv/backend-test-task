<?php

declare(strict_types=1);

namespace App\Service\PaymentAdapter;

use Exception;

class PaymentAdapterNotFoundException extends Exception
{
    public function __construct(string $paymentProvider)
    {
        parent::__construct("Payment adapter not found for $paymentProvider");
    }
}