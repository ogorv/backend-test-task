<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Purchase;
use App\Enum\PaymentProviderEnum;
use App\Enum\PurchaseStatusEnum;
use App\Repository\PaymentProviderRepository;
use App\Repository\ProductRepository;
use App\Service\PaymentAdapter\PaymentAdapterManager;
use App\Service\PaymentAdapter\PaymentAdapterNotFoundException;
use App\Service\PaymentAdapter\PaymentErrorException;
use Doctrine\ORM\EntityManagerInterface;

final readonly class PurchaseMaker
{
    public function __construct(
        private EntityManagerInterface    $entityManager,
        private ProductRepository         $productRepository,
        private PriceCalculation          $priceCalculation,
        private PaymentProviderRepository $paymentProviderRepository,
        private PaymentAdapterManager     $paymentAdapterManager,
    ) {
    }

    /*
     * В идеале еще нужно добавить валидацию, существует ли продукт (и его количество), платежный провайдер и возвращать соответсвующий ответ.
     * Так же для статуса покупки лучше использовать workflow https://symfony.com/doc/6.4/workflow.html
     * И сам запрос к платежному провайдеру лучше сделать асинхронным, используя symfony/messenger https://symfony.com/doc/6.4/messenger.html#transports-async-queued-messages
     */
    /** @throws PaymentAdapterNotFoundException|PaymentErrorException */
    public function makePurchase(
        int                 $productId,
        PaymentProviderEnum $paymentProviderEnum,
        string              $taxNumber,
        ?string             $couponCode = null,
    ): float {
        $product         = $this->productRepository->find($productId);
        $paymentProvider = $this->paymentProviderRepository->findOneBy(['alias' => $paymentProviderEnum]);

        $price = $this->priceCalculation->calculate($productId, $taxNumber, $couponCode);

        $purchase = new Purchase(
            $product,
            $taxNumber,
            $paymentProvider,
            $price,
        );

        $this->entityManager->persist($purchase);
        $this->entityManager->flush();

        $this->paymentAdapterManager->getPaymentAdapter($paymentProviderEnum)->pay($price, $product->getCurrency());

        $product->reduceCount();

        $this->entityManager->persist($product);
        $purchase->setStatus(PurchaseStatusEnum::PAID);
        $this->entityManager->flush();

        return $price;
    }
}