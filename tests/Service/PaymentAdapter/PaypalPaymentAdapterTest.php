<?php

declare(strict_types=1);

namespace App\Tests\Service\PaymentAdapter;

use App\Entity\Currency;
use App\Helper\MathHelper;
use App\Service\PaymentAdapter\PaymentErrorException;
use App\Service\PaymentAdapter\PaypalPaymentAdapter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

#[CoversClass(PaypalPaymentAdapter::class)]
class PaypalPaymentAdapterTest extends TestCase
{
    public function testPaySuccess(): void
    {
        $amount      = 100.00;
        $minorAmount = 10000;

        $matchHelper = $this->createMock(MathHelper::class);
        $matchHelper->expects($this->once())->method('getMinorUnits')->with($amount, 2)->willReturn($minorAmount);

        $currency = $this->createStub(Currency::class);
        $currency->method('getPrecision')->willReturn(2);

        $paypalPaymentProcessor = $this->createMock(PaypalPaymentProcessor::class);
        $paypalPaymentProcessor->expects($this->once())->method('pay')->with($minorAmount);

        $paypalPaymentAdapter = new PaypalPaymentAdapter($paypalPaymentProcessor, $matchHelper);
        $paypalPaymentAdapter->pay($amount, $currency);
    }

    public function testPayError(): void
    {
        $amount      = 100.00;
        $minorAmount = 10000;

        $matchHelper = $this->createMock(MathHelper::class);
        $matchHelper->expects($this->once())->method('getMinorUnits')->with($amount, 2)->willReturn($minorAmount);

        $currency = $this->createStub(Currency::class);
        $currency->method('getPrecision')->willReturn(2);

        $paypalPaymentProcessor = $this->createMock(PaypalPaymentProcessor::class);
        $paypalPaymentProcessor
            ->expects($this->once())
            ->method('pay')
            ->with($minorAmount)
            ->willThrowException($this->createStub(Throwable::class));

        $paypalPaymentAdapter = new PaypalPaymentAdapter($paypalPaymentProcessor, $matchHelper);

        $this->expectException(PaymentErrorException::class);
        $paypalPaymentAdapter->pay($amount, $currency);
    }
}