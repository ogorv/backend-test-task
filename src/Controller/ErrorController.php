<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PaymentAdapter\PaymentErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ErrorController extends AbstractController
{
    /** @throws Throwable */
    public function show(Request $request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof HttpException) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => $exception->getMessage(),
                ], $exception->getStatusCode()
            );
        }

        if ($exception instanceof PaymentErrorException) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => 'Payment error occurred.',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            [
                'success' => false,
                'message' => 'Internal server error.',
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}