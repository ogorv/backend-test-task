<?php

declare(strict_types=1);

namespace App\Service\PaymentAdapter;

use App\Entity\Currency;
use App\Enum\PaymentProviderEnum;
use App\Helper\MathHelper;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

#[AutoconfigureTag(PaymentAdapterManager::PAYMENT_ADAPTER_MANAGER_TAG, [PaymentAdapterManager::PROVIDER => PaymentProviderEnum::PAYPAL->value])]
readonly class PaypalPaymentAdapter implements PaymentAdapterInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor,
        private MathHelper             $mathHelper,
    ) {
    }

    /** @inheritDoc */
    public function pay(float $amount, Currency $currency): void
    {
        try {
            $minor = $this->mathHelper->getMinorUnits($amount, $currency->getPrecision());

            $this->paypalPaymentProcessor->pay($minor);
        } catch (Throwable $e) {
            throw new PaymentErrorException($e->getMessage(), $e->getCode(), $e);
        }
    }
}