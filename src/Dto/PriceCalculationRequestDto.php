<?php

declare(strict_types=1);

namespace App\Dto;

class PriceCalculationRequestDto
{
    public function __construct(
        private readonly int    $product,
        private readonly string $taxNumber,
        private readonly string $couponCode,
    ) {
    }

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}