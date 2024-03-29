<?php

namespace App\Dto;

use App\Entity\Currency;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

readonly class AccountDto
{
    public Currency $currency;
    public function __construct(
        #[Assert\NotBlank]
        #[Type('integer')]
        public int   $currency_id,
        #[Assert\NotBlank]
        #[Type('float')]
        public float $amount
    )
    {
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }
}