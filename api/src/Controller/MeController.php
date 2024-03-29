<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: "api/me", name: "api_me_")]
class MeController extends AbstractController
{
    #[Route(path: "", name: "info", methods: ["GET"])]
    public function all(): Response
    {
        return $this->json([
                'message' => 'success',
            ]
        );
    }
}
