<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PriceCalculationRequestDto;
use App\Service\PriceCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(format: 'json')]
class ProductController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: [Request::METHOD_POST])]
    public function index(
        #[MapRequestPayload(acceptFormat: 'json')]
        PriceCalculationRequestDto $priceCalculationRequestDto,
        PriceCalculation           $priceCalculation,
    ): Response {
        $price = $priceCalculation->calculate(
            $priceCalculationRequestDto->getProduct(),
            $priceCalculationRequestDto->getTaxNumber(),
            $priceCalculationRequestDto->getCouponCode()
        );

        return $this->json(['price' => $price]);
    }
}
