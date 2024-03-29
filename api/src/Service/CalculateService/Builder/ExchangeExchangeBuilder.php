<?php

namespace App\Service\CalculateService\Builder;

use App\Entity\Account;
use App\Entity\CurrencyRate;
use App\Exception\ServiceException;
use App\Service\CalculateService\Interface\ExchangeBuilderInterface;
use App\Service\CalculateService\Object\DstAmount;
use App\Service\CalculateService\Object\SrcAmount;

class ExchangeExchangeBuilder implements ExchangeBuilderInterface
{
    private SrcAmount $srcAmount;
    private DstAmount $dstAmount;

    public function __construct(
        private readonly CurrencyRate $currencyRate,
        private readonly Account      $accountSrc,
        private readonly Account      $accountDst,
        private readonly float        $amount
    )
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->srcAmount = new SrcAmount();
        $this->dstAmount = new DstAmount();
    }

    public function calculateSrcPrice(): void
    {
        if ($this->amount > $this->accountSrc->getAmount()) {
            throw new ServiceException("limit error");
        }

        $this->srcAmount->parts[] = $this->accountSrc->getAmount();
        $this->srcAmount->parts[] = $this->amount;
    }

    public function calculateDstPrice(): void
    {
        $convertedAmount = $this->currencyRate->getRate() * $this->amount;

        $this->dstAmount->parts[] = $this->accountDst->getAmount();
        $this->dstAmount->parts[] = $convertedAmount;
    }

    public function getSrcAmount(): SrcAmount
    {
        return $this->srcAmount;
    }

    public function getDstAmount(): DstAmount
    {
        return $this->dstAmount;
    }


}