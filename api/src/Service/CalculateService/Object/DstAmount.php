<?php

namespace App\Service\CalculateService\Object;

class DstAmount
{
    public array $parts = [];

    public function getAmount(): float
    {
        return array_sum($this->parts);
    }

}