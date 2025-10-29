<?php

declare(strict_types=1);

namespace App\Tests\Service\PaymentAdapter;


use App\Enum\PaymentProviderEnum;
use App\Service\PaymentAdapter\PaymentAdapterInterface;
use App\Service\PaymentAdapter\PaymentAdapterManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentAdapterManager::class)]
class PaymentAdapterManagerTest extends TestCase
{
    public function testAddAndGetPaymentAdapter(): void
    {
        $providerFactoryManager = new PaymentAdapterManager();
        $paypalPaymentAdapter   = $this->createMock(PaymentAdapterInterface::class);

        $providerFactoryManager->addPaymentAdapter(PaymentProviderEnum::PAYPAL, $paypalPaymentAdapter);

        $this->assertSame(
            $paypalPaymentAdapter,
            $providerFactoryManager->getPaymentAdapter(PaymentProviderEnum::PAYPAL),
        );
    }
}