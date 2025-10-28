<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\PurchaseRequestDto;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PurchaseRequestDto::class)]
class PurchaseRequestDtoTest extends TestCase
{
    public function testGetters(): void
    {
        $dto = new PurchaseRequestDto(1, 'DE123456789', 'D15', 'paypal');

        $this->assertSame('DE123456789', $dto->getTaxNumber());
        $this->assertSame('D15', $dto->getCouponCode());
        $this->assertSame(1, $dto->getProduct());
        $this->assertSame('paypal', $dto->getPaymentProcessor());
    }
}