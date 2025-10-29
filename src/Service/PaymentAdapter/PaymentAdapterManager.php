<?php

declare(strict_types=1);

namespace App\Service\PaymentAdapter;

use App\Enum\PaymentProviderEnum;

class PaymentAdapterManager
{
    public const string PAYMENT_ADAPTER_MANAGER_TAG = 'app.payment_adapter_manager';

    public const string PROVIDER = 'provider';

    /**
     * @var array<PaymentAdapterInterface>
     */
    private array $paymentAdapters;

    public function addPaymentAdapter(
        PaymentProviderEnum     $paymentProviderEnum,
        PaymentAdapterInterface $paymentAdapter,
    ): void {
        $this->paymentAdapters[$paymentProviderEnum->value] = $paymentAdapter;
    }

    /** @throws PaymentAdapterNotFoundException */
    public function getPaymentAdapter(PaymentProviderEnum $paymentProviderEnum): PaymentAdapterInterface
    {
        if (isset($this->paymentAdapters[$paymentProviderEnum->value])) {
            return $this->paymentAdapters[$paymentProviderEnum->value];
        }

        throw new PaymentAdapterNotFoundException($paymentProviderEnum->value);
    }
}