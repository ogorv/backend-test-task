<?php

declare(strict_types=1);

namespace App\Service\PaymentAdapter;

use App\Entity\Currency;
use App\Enum\PaymentProviderEnum;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

#[AutoconfigureTag(PaymentAdapterManager::PAYMENT_ADAPTER_MANAGER_TAG, [PaymentAdapterManager::PROVIDER => PaymentProviderEnum::STRIPE->value])]
readonly class StripePaymentAdapter implements PaymentAdapterInterface
{
    public function __construct(private StripePaymentProcessor $stripePaymentProcessor)
    {
    }

    /** @inheritDoc */
    public function pay(float $amount, Currency $currency): void
    {
        if (!$this->stripePaymentProcessor->processPayment($amount)) {
            throw new PaymentErrorException('Payment failed');
        }
    }
}