<?php

namespace App\Controller;

use App\Dto\ExchangeDto;
use App\Service\CalculateService\CalculateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route(path: "api/calculate", name: "api_calculate_")]
class CalculateController extends AbstractController
{
    public function __construct(private readonly CalculateService $calculateService)
    {
    }

    #[Route(path: "/exchange", name: "exchange", methods: ["POST"])]
    #[OA\Response(
        response: 200,
        description: "Return accounts",
        content: [
            "application/json" => new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "message",
                        type: "string",
                        example: "success"
                    )
                ],
                type: "object"
            )
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['account_src_id', 'account_dst_id', 'amount'],
            properties: [
                new OA\Property(
                    property: "account_src_id",
                    type: "integer",
                    example: 1
                ),
                new OA\Property(
                    property: "account_dst_id",
                    type: "integer",
                    example: 1
                ),
                new OA\Property(
                    property: "amount",
                    type: "float",
                    example: 1000
                ),
            ]
        )
    )]
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
