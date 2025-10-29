<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\PaymentProviderEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequestDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Product is required.'), Assert\Regex(pattern: '/^\d+$/', message: 'Product ID must be a number.')]
        private readonly ?int    $product,
        #[Assert\NotBlank(message: 'Tax number is required.'), Assert\Regex(pattern: '/^(DE[0-9]{9}|IT[0-9]{11}|GR[0-9]{9}|FR[a-zA-Z]{2}[0-9]{9})$/', message: 'Tax number is not valid.')]
        private readonly ?string $taxNumber,
        #[Assert\NotBlank(message: 'Payment processor is required.')]
        #[Assert\Choice(callback: [PaymentProviderEnum::class, 'getValues'], message: 'Payment processor is not valid.')]
        private readonly ?string $paymentProcessor,
        #[Assert\Regex(pattern: '/^[P,F]\d{1,3}$/', message: 'Coupon code is not valid.')]
        private readonly ?string $couponCode = null,
    ) {
    }

    public function getProduct(): ?int
    {
        return $this->product;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function getPaymentProcessor(): ?string
    {
        return $this->paymentProcessor;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }
}