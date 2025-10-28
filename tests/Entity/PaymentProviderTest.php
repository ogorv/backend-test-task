<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Currency;
use App\Entity\PaymentProvider;
use App\Enum\PaymentProviderEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Currency::class)]
class PaymentProviderTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $paymentProvider = new PaymentProvider(PaymentProviderEnum::PAYPAL);

        $this->assertNull($paymentProvider->getId());
        $this->assertSame(PaymentProviderEnum::PAYPAL, $paymentProvider->getAlias());
    }
}
