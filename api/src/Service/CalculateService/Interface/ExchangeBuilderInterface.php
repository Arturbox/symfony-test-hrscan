<?php

namespace App\Service\CalculateService\Interface;

interface ExchangeBuilderInterface
{
    public function calculateSrcPrice(): void;

    public function calculateDstPrice(): void;
}