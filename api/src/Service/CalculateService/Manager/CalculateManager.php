<?php

namespace App\Service\CalculateService\Manager;

use App\Service\CalculateService\Interface\ExchangeBuilderInterface;

class CalculateManager
{
    private ExchangeBuilderInterface $builder;

    public function setBuilder(ExchangeBuilderInterface $builder): void
    {
        $this->builder = $builder;
    }


    public function exchange(): void
    {
        $this->builder->calculateSrcPrice();
        $this->builder->calculateDstPrice();
    }
}