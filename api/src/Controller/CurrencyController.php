<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: "api/currencies", name: "api_currencies")]
class CurrencyController extends AbstractController
{

    public function __construct(private readonly CurrencyRepository $repository)
    {
    }

    #[Route(path: "", name: "all", methods: ["GET"])]
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
