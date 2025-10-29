<?php

declare(strict_types=1);

namespace App\Tests\Service\PaymentAdapter;

use App\Entity\Currency;
use App\Service\PaymentAdapter\PaymentErrorException;
use App\Service\PaymentAdapter\StripePaymentAdapter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

#[CoversClass(StripePaymentAdapter::class)]
class StripePaymentAdapterTest extends TestCase
{
    public function testPaySuccess(): void
    {
        $amount   = 100.00;
        $currency = $this->createStub(Currency::class);

        $stripePaymentProcessor = $this->createMock(StripePaymentProcessor::class);
        $stripePaymentProcessor->expects($this->once())->method('processPayment')->with($amount)->willReturn(true);

        $stripePaymentAdapter = new StripePaymentAdapter($stripePaymentProcessor);
        $stripePaymentAdapter->pay($amount, $currency);
    }

    public function testPayError(): void
    {
        $amount   = 100.00;
        $currency = $this->createStub(Currency::class);

        $stripePaymentProcessor = $this->createMock(StripePaymentProcessor::class);
        $stripePaymentProcessor->expects($this->once())->method('processPayment')->with($amount)->willReturn(false);

        $stripePaymentAdapter = new StripePaymentAdapter($stripePaymentProcessor);

        $this->expectException(PaymentErrorException::class);
        $stripePaymentAdapter->pay($amount, $currency);
    }
}