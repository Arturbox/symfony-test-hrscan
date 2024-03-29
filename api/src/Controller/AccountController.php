<?php

namespace App\Controller;

use App\Dto\AccountDto;
use App\Entity\Account;
use App\Entity\Currency;
use App\Factory\AccountFactory;
use App\Repository\AccountRepository;
use App\ValueResolver\CurrencyValueResolver;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route(path: "api/accounts", name: "api_accounts_")]
class AccountController extends AbstractController
{

    public function __construct(private readonly AccountRepository $repository)
    {
    }


    #[Route(path: "", name: "all", methods: ["GET"])]
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
                    ),
                    new OA\Property(
                        property: "data",
                        type: "array",
                        items: new OA\Items(
                            ref: "#/components/schemas/Account"
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


    #[Route(path: "/{id}", name: "byId", methods: ["GET"])]
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
                    ),
                    new OA\Property(
                        property: "data",
                        ref: "#/components/schemas/Account"
                    )
                ],
                type: "object"
            )
        ]
    )]
    #[OA\Parameter(
        name: "id", required: true, in: "path", schema: new OA\Schema(type: "integer"), example: 1
    )]
    function getById(int $id): Response
    {
        return $this->json([
            'message' => 'success',
            'data' => $this->repository->findById($id)
        ], Response::HTTP_OK);
    }

    #[Route(path: "/{id}", name: "update", methods: ["PUT"])]
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
                    ),
                    new OA\Property(
                        property: "data",
                        ref: "#/components/schemas/Account"
                    )
                ],
                type: "object"
            )
        ]
    )]
    #[OA\Parameter(
        name: "id", required: true, in: "path", schema: new OA\Schema(type: "integer"), example: 1
    )]
    public function update(
        int                                                     $id,
        #[MapRequestPayload] AccountDto                         $accountDto,
        #[ValueResolver(CurrencyValueResolver::class)] Currency $currency
    ): Response
    {
        $accountDto->setCurrency($currency);
        $account = $this->repository->findById($id);

        if ($account->getCurrency() !== $accountDto->currency) {
            $account->setCurrency($accountDto->currency);
        }
        if ($account->getAmount() != $accountDto->amount) {
            $account->setAmount($accountDto->amount);
        }

        $this->repository->save();

        return $this->json([
            'message' => 'success',
            'data' => $account
        ], Response::HTTP_OK);
    }

    #[Route(path: "", name: "create", methods: ["POST"])]
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
                    ),
                    new OA\Property(
                        property: "data",
                        ref: "#/components/schemas/Account"
                    )
                ],
                type: "object"
            )
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['currency_id', 'amount'],
            properties: [
                new OA\Property(
                    property: "currency_id",
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
    public function create(
        #[MapRequestPayload] AccountDto                          $accountDto,
        #[ValueResolver(CurrencyValueResolver::class)] ?Currency $currency
    ): Response
    {
        $accountDto->setCurrency($currency);
        $account = $this->repository->create(AccountFactory::create($accountDto));

        return $this->json([
            'message' => 'success',
            'data' => $account
        ], Response::HTTP_CREATED);
    }

    #[Route(path: "/{id}", name: "delete", methods: ["DELETE"])]
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
    #[OA\Parameter(
        name: "id", required: true, in: "path", schema: new OA\Schema(type: "integer"), example: 1
    )]
    public function delete(
        #[MapEntity(id: 'id')] Account $account
    ): Response
    {
        $this->repository->delete($account);

        return $this->json([
            'message' => 'success',
        ], Response::HTTP_CREATED);
    }
}
