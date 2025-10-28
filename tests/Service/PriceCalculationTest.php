<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CouponTypeEnum;
use App\Helper\MathHelper;
use App\Repository\CountryRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PriceCalculation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PriceCalculation::class)]
class PriceCalculationTest extends TestCase
{
    public function testCalculateWithoutCoupon(): void
    {
        $productId = 1;
        $taxNumber = 'DE123456789';

        $product = $this->createStub(Product::class);
        $product->method('getPrice')->willReturn('100');

        $country = $this->createStub(Country::class);
        $country->method('getTaxPercent')->willReturn(19.00);

        $countryRepository = $this->createMock(CountryRepository::class);
        $countryRepository->expects($this->once())->method('requireOneByCode')->willReturn($country);

        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository
            ->expects($this->once())
            ->method('requireOneWithCurrencyById')
            ->with($productId)
            ->willReturn($product);

        $mathHelper = $this->createMock(MathHelper::class);
        $mathHelper
            ->expects($this->once())
            ->method('addPercent')
            ->with(100, 19.00)
            ->willReturn(119.00);

        $priceCalculation = new PriceCalculation(
            $productRepository,
            $countryRepository,
            $this->createStub(CouponRepository::class),
            $mathHelper
        );

        $result = $priceCalculation->calculate($productId, $taxNumber);

        $this->assertSame(119.00, $result);
    }

    public function testCalculateWithPercentageCoupon(): void
    {
        $productId  = 1;
        $taxNumber  = 'DE123456789';
        $couponCode = 'P6';

        $product = $this->createStub(Product::class);
        $product->method('getPrice')->willReturn('100');

        $country = $this->createStub(Country::class);
        $country->method('getTaxPercent')->willReturn(19.00);

        $countryRepository = $this->createMock(CountryRepository::class);
        $countryRepository->expects($this->once())->method('requireOneByCode')->willReturn($country);

        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository
            ->expects($this->once())
            ->method('requireOneWithCurrencyById')
            ->with($productId)
            ->willReturn($product);

        $mathHelper = $this->createMock(MathHelper::class);
        $mathHelper
            ->expects($this->once())
            ->method('addPercent')
            ->with(94, 19.00)
            ->willReturn(111.86);

        $mathHelper
            ->expects($this->once())
            ->method('subPercent')
            ->with(100, 6.00)
            ->willReturn(94.00);

        $coupon = $this->createStub(Coupon::class);
        $coupon->method('getDiscount')->willReturn(6.00);
        $coupon->method('getType')->willReturn(CouponTypeEnum::PERCENTAGE);

        $couponRepository = $this->createMock(CouponRepository::class);

        $couponRepository->expects($this->once())->method('requireOneByCode')->with($couponCode)->willReturn($coupon);

        $priceCalculation = new PriceCalculation(
            $productRepository,
            $countryRepository,
            $couponRepository,
            $mathHelper
        );

        $result = $priceCalculation->calculate($productId, $taxNumber, $couponCode);

        $this->assertSame(111.86, $result);
    }

    public function testCalculateWithFixedCoupon(): void
    {
        $productId  = 1;
        $taxNumber  = 'DE123456789';
        $couponCode = 'F9';

        $product = $this->createStub(Product::class);
        $product->method('getPrice')->willReturn('100');

        $country = $this->createStub(Country::class);
        $country->method('getTaxPercent')->willReturn(19.00);

        $countryRepository = $this->createMock(CountryRepository::class);
        $countryRepository->expects($this->once())->method('requireOneByCode')->willReturn($country);

        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository
            ->expects($this->once())
            ->method('requireOneWithCurrencyById')
            ->with($productId)
            ->willReturn($product);

        $mathHelper = $this->createMock(MathHelper::class);
        $mathHelper
            ->expects($this->once())
            ->method('addPercent')
            ->with(91, 19.00)
            ->willReturn(108.29);

        $coupon = $this->createStub(Coupon::class);
        $coupon->method('getDiscount')->willReturn(9.00);
        $coupon->method('getType')->willReturn(CouponTypeEnum::FIXED);

        $couponRepository = $this->createMock(CouponRepository::class);

        $couponRepository->expects($this->once())->method('requireOneByCode')->with($couponCode)->willReturn($coupon);

        $priceCalculation = new PriceCalculation(
            $productRepository,
            $countryRepository,
            $couponRepository,
            $mathHelper
        );

        $result = $priceCalculation->calculate($productId, $taxNumber, $couponCode);

        $this->assertSame(108.29, $result);
    }
}