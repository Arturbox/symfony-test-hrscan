<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Account",
    description: "Account entity",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "amount", type: "float", example: 100),
        new OA\Property(property: "currency", ref: "#/components/schemas/Currency"),
    ]
)]
#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ORM\Table(name: 'accounts')]
#[ORM\UniqueConstraint(name: 'account_client_id_currency_id_unique', columns: ['client_id', 'currency_id'])]
class Account
{
    #[ORM\Id, ORM\Column(type: 'bigint'), ORM\GeneratedValue('IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: Types::FLOAT)]
    private float $amount = 0.0;

    #[ORM\ManyToOne(targetEntity: Client::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: Currency::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function setCurrency(Currency $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function setClient(Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}