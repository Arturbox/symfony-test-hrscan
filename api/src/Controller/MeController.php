<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route(path: "api/me", name: "api_me_")]
class MeController extends AbstractController
{
    #[Route(path: "", name: "info", methods: ["GET"])]
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
    public function all(): Response
    {
        return $this->json([
                'message' => 'success',
            ]
        );
    }
}
