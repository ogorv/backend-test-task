<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Coupon;
use App\Enum\CouponTypeEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Coupon::class)]
class CouponTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $coupon = new Coupon('P10', CouponTypeEnum::PERCENTAGE, 10.0);

        $this->assertNull($coupon->getId());
        $this->assertSame('P10', $coupon->getCode());
        $this->assertSame(CouponTypeEnum::PERCENTAGE, $coupon->getType());
        $this->assertSame(10.0, $coupon->getDiscount());

        $coupon->setCode('F5');
        $coupon->setType(CouponTypeEnum::FIXED);
        $coupon->setDiscount(5.0);

        $this->assertSame('F5', $coupon->getCode());
        $this->assertSame(CouponTypeEnum::FIXED, $coupon->getType());
        $this->assertSame(5.0, $coupon->getDiscount());
    }
}
