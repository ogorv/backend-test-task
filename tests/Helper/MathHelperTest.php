<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\MathHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(MathHelper::class)]
class MathHelperTest extends TestCase
{

    #[TestWith([100, 10, 90.00])]
    #[TestWith([200, 0.5, 199.00])]
    #[TestWith([0.3, 0.3, 0.2991])]
    #[TestWith([30, 0.5, 29.85])]
    #[TestWith([30, -0.5, 30.15])]
    #[TestWith([0.5, 20, 0.4])]
    #[TestWith([0.5, -20, 0.6])]
    public function testSubPercent(float $amount, float $percent, float $result): void
    {
        $matchHelper = new MathHelper();

        $this->assertSame($result, $matchHelper->subPercent($amount, $percent));
    }

    #[TestWith([100, 10, 10.00])]
    #[TestWith([100, -10, -10.00])]
    #[TestWith([100, 50, 50.00])]
    #[TestWith([100, -50, -50.00])]
    #[TestWith([100, 1, 1.00])]
    #[TestWith([0.5, 20, 0.10])]
    public function testGetPercentFromNumber(float $number, float $percent, float $result): void
    {
        $matchHelper = new MathHelper();

        $this->assertSame($result, $matchHelper->getPercentFromNumber($number, $percent));
    }

    #[TestWith([100, -10, 90.00])]
    #[TestWith([100, 10, 110.00])]
    #[TestWith([200, 0.5, 201.00])]
    #[TestWith([200, -0.5, 199.00])]
    #[TestWith([0.3, 0.3, 0.3009])]
    #[TestWith([30, 0.5, 30.15])]
    #[TestWith([30, -0.5, 29.85])]
    #[TestWith([0.5, 20, 0.6])]
    #[TestWith([0.5, -20, 0.4])]
    public function testAddPercentFee(float $amount, float $percent, float $result): void
    {
        $matchHelper = new MathHelper();

        $this->assertSame($result, $matchHelper->addPercent($amount, $percent));
    }
}