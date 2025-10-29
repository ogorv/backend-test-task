<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Enum\PaymentProviderEnum;
use App\Service\PaymentAdapter\PaymentAdapterManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PaymentAdapterManagerPass implements CompilerPassInterface
{
    /** @inheritDoc */
    public function process(ContainerBuilder $container): void
    {
        // always first check if the primary service is defined
        if (!$container->has(PaymentAdapterManager::class)) {
            return;
        }

        $definition     = $container->findDefinition(PaymentAdapterManager::class);
        $taggedServices = $container->findTaggedServiceIds(PaymentAdapterManager::PAYMENT_ADAPTER_MANAGER_TAG);

        foreach ($taggedServices as $id => $tags) {
            if (!isset($tags[0][PaymentAdapterManager::PROVIDER])) {
                throw new CompilerPassException("Provider factory tag not found in $id");
            }

            $paymentProviderEnum = PaymentProviderEnum::from($tags[0][PaymentAdapterManager::PROVIDER]);

            $definition->addMethodCall('addPaymentAdapter', [$paymentProviderEnum, new Reference($id)]);
        }
    }
}