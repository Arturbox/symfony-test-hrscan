<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

readonly class ExchangeDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Type('integer')]
        public int   $account_src_id,
        #[Assert\NotBlank]
        #[Type('integer')]
        public int   $account_dst_id,
        #[Assert\NotBlank]
        #[Type('float')]
        public float $amount,
    )
    {
    }

    public function getAccountIds(): array
    {
        return [
            $this->account_src_id,
            $this->account_dst_id,
        ];
    }

}