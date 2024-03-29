<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_CODE', fields: ['code'])]
#[ORM\Table(name: 'currencies')]
class Currency
{
    #[ORM\Id, ORM\Column(type: 'bigint'), ORM\GeneratedValue('IDENTITY')]
    private ?int $id = null;


    #[ORM\Column]
    public string $name = '';

    #[ORM\Column]
    public string $code = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }
}