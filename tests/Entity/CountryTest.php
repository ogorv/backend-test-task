<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Country;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Country::class)]
class CountryTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $country = new Country('DE', 19.00);

        $this->assertNull($country->getId());
        $this->assertEquals('DE', $country->getCode());
        $this->assertEquals(19.00, $country->getTaxPercent());


        $country->setTaxPercent(21.00);

        $this->assertEquals(21.00, $country->getTaxPercent());
    }
}