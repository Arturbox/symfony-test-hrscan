<?php

namespace App\Controller;

use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route(path: "api/currencies", name: "api_currencies")]
class CurrencyController extends AbstractController
{

    public function __construct(private readonly CurrencyRepository $repository)
    {
    }

    #[Route(path: "", name: "all", methods: ["GET"])]
    #[OA\Response(
        response: 200,
        description: "Return currencies",
        content: [
            "application/json" => new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "message",
                        type: "string",
                        example: "success"
                    ),
                    new OA\Property(
                        property: "data",
                        type: "array",
                        items: new OA\Items(
                            ref: "#/components/schemas/Currency"
                        )
                    )
                ],
                type: "object"
            )
        ]
    )]
    public function all(): Response
    {
        $data = $this->repository->findAll();
        return $this->json([
                'message' => 'success',
                'data' => $data
            ]
        );
    }
}
