<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PriceCalculationRequestDto;
use App\Dto\PurchaseRequestDto;
use App\Enum\PaymentProviderEnum;
use App\Service\PriceCalculation;
use App\Service\PurchaseMaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(format: 'json')]
class ProductController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: [Request::METHOD_POST])]
    public function calculatePrice(
        #[MapRequestPayload(acceptFormat: 'json')]
        PriceCalculationRequestDto $priceCalculationRequestDto,
        PriceCalculation           $priceCalculation,
    ): Response {
        $price = $priceCalculation->calculate(
            $priceCalculationRequestDto->getProduct(),
            $priceCalculationRequestDto->getTaxNumber(),
            $priceCalculationRequestDto->getCouponCode()
        );

        return $this->json(['success' => true, 'price' => $price]);
    }

    #[Route('/purchase', name: 'purchase', methods: [Request::METHOD_POST])]
    public function purchase(
        #[MapRequestPayload(acceptFormat: 'json')]
        PurchaseRequestDto $purchaseRequestDto,
        PurchaseMaker      $purchaseMaker,
    ): Response {
       $price = $purchaseMaker->makePurchase(
            $purchaseRequestDto->getProduct(),
            PaymentProviderEnum::from($purchaseRequestDto->getPaymentProcessor()),
            $purchaseRequestDto->getTaxNumber(),
            $purchaseRequestDto->getCouponCode(),
        );

        return $this->json(['success' => true, 'price' => $price]);
    }
}
