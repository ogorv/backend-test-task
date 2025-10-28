<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Currency;
use App\Entity\Product;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Product::class)]
class ProductTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $currency = $this->createStub(Currency::class);
        $product  = new Product(
            'Iphone',
            $currency,
            '10.00',
            10,
        );

        $this->assertNull($product->getId());
        $this->assertSame('Iphone', $product->getTitle());
        $this->assertSame($currency, $product->getCurrency());
        $this->assertSame('10.00', $product->getPrice());
        $this->assertSame(10, $product->getCount());
    }
}
