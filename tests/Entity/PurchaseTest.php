<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Coupon;
use App\Entity\PaymentProvider;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Enum\PurchaseStatusEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Purchase::class)]
class PurchaseTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $product         = $this->createStub(Product::class);
        $paymentProvider = $this->createStub(PaymentProvider::class);
        $taxNumber       = 'DE123456789';
        $price           = 100.0;

        $purchase = new Purchase(
            $product,
            $taxNumber,
            $paymentProvider,
            $price,
            PurchaseStatusEnum::NEW
        );

        $this->assertNull($purchase->getId());
        $this->assertSame($product, $purchase->getProduct());
        $this->assertSame($taxNumber, $purchase->getTaxNumber());
        $this->assertSame($paymentProvider, $purchase->getPaymentProvider());
        $this->assertSame($price, $purchase->getPrice());
        $this->assertSame(PurchaseStatusEnum::NEW, $purchase->getStatus());

        $purchase->setStatus(PurchaseStatusEnum::PAID);

        $this->assertSame(PurchaseStatusEnum::PAID, $purchase->getStatus());
    }
}