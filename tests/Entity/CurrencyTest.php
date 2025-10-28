<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Currency;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Currency::class)]
class CurrencyTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $currency = new Currency('DE', 2);

        $this->assertNull($currency->getId());
        $this->assertSame('DE', $currency->getCode());
        $this->assertSame(2, $currency->getPrecision());
    }
}
