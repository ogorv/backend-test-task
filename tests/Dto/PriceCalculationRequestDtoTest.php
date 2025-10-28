<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\PriceCalculationRequestDto;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PriceCalculationRequestDto::class)]
class PriceCalculationRequestDtoTest extends TestCase
{
    public function testGetters(): void
    {
        $dto = new PriceCalculationRequestDto(1, 'DE123456789', 'D15');

        $this->assertSame('DE123456789', $dto->getTaxNumber());
        $this->assertSame('D15', $dto->getCouponCode());
        $this->assertSame(1, $dto->getProduct());
    }
}