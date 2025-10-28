<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Enum\CouponTypeEnum;
use App\Helper\MathHelper;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\NoResultException;
use InvalidArgumentException;

class PriceCalculation
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CountryRepository $countryRepository,
        private readonly CouponRepository  $couponRepository,
        private readonly MathHelper        $mathHelper,
    ) {
    }

    /**
     * @throws NoResultException
     */
    public function calculate(int $productId, string $taxNumber, ?string $couponCode = null): float
    {
        $product     = $this->productRepository->requireOneWithCurrencyById($productId);
        $countryCode = substr($taxNumber, 0, 2);

        $country = $this->countryRepository->requireOneByCode($countryCode);
        $price   = (float)$product->getPrice();

        if ($couponCode) {
            $coupon = $this->couponRepository->requireOneByCode($couponCode);
            $price  = $this->calculateCouponDiscount($price, $coupon);
        }

        return $this->mathHelper->addPercent($price, $country->getTaxPercent());
    }

    private function calculateCouponDiscount(float $price, Coupon $coupon): float
    {
        if ($coupon->getType() === CouponTypeEnum::PERCENTAGE) {
            return $this->mathHelper->subPercent($price, $coupon->getDiscount());
        }

        if ($coupon->getType() === CouponTypeEnum::FIXED) {
            return $price - $coupon->getDiscount();
        }

        throw new InvalidArgumentException('Invalid coupon type');
    }
}