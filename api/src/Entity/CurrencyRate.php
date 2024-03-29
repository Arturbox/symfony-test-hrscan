<?php

namespace App\Entity;

use App\Repository\CurrencyRateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRateRepository::class)]
#[ORM\Table(name: 'currency_rates')]
#[ORM\UniqueConstraint(name: 'currency_rate_src_id_dst_unique', columns: ['src_id', 'dst_id'])]
class CurrencyRate
{
    #[ORM\Id, ORM\Column(type: 'bigint'), ORM\GeneratedValue('IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: Types::FLOAT)]
    private float $rate = 0.0;

    #[ORM\ManyToOne(targetEntity: Currency::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $src = null;

    #[ORM\ManyToOne(targetEntity: Currency::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $dst = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getRate(): float
    {
        return $this->rate;
    }

    public function getSrc(Currency $currency): Currency
    {
        return $this->src;
    }

    public function getDst(Currency $currency): Currency
    {
        return $this->dst;
    }


    public function setRate(float $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function setSrc(Currency $currency): static
    {
        $this->src = $currency;

        return $this;
    }

    public function setDst(Currency $currency): static
    {
        $this->dst = $currency;

        return $this;
    }
}