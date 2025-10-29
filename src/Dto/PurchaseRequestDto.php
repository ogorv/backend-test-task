<?php

declare(strict_types=1);

namespace App\Dto;

class PurchaseRequestDto
{
    public function __construct(
        private readonly int     $product,
        private readonly string  $taxNumber,
        private readonly string  $paymentProcessor,
        private readonly ?string $couponCode = null,
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

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }
}