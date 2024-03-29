<?php

namespace App\Controller;

use App\Dto\ExchangeDto;
use App\Service\CalculateService\CalculateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: "api/calculate", name: "api_calculate_")]
class CalculateController extends AbstractController
{
    public function __construct(private readonly CalculateService $calculateService)
    {
    }

    #[Route(path: "/exchange", name: "exchange", methods: ["POST"])]
    public function exchange(
        #[MapRequestPayload] ExchangeDto $exchangeDto,
    ): Response
    {
        $this->calculateService->exchange($exchangeDto);
        return $this->json([
                'message' => 'success',
            ]
        );
    }

}
