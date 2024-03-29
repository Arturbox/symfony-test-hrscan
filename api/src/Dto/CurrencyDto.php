<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

readonly class CurrencyDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Type('string')]
        public string $name,
        #[Assert\NotBlank]
        #[Type('string')]
        public string $code
    )
    {
    }

}