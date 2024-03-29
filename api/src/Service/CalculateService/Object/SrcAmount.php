<?php

namespace App\Service\CalculateService\Object;

class SrcAmount
{

    public array $parts = [];

    public function getAmount(): float
    {
        return $this->parts[0] - $this->parts[1];
    }

}