<?php

namespace App\Service\CalculateService;

use App\Dto\ExchangeDto;
use App\Exception\ServiceException;
use App\Repository\AccountRepository;
use App\Repository\CurrencyRateRepository;
use App\Service\CalculateService\Builder\ExchangeExchangeBuilder;
use App\Service\CalculateService\Manager\CalculateManager;

readonly final class CalculateService
{
    public function __construct(
        private CalculateManager       $calculateManager,
        private AccountRepository      $accountRepository,
        private CurrencyRateRepository $rateRepository
    )
    {

    }


    public function exchange(ExchangeDto $exchangeDto): void
    {
        try {
            list($accountSrc, $accountDst) = $this->accountRepository->findMultipleIds($exchangeDto->getAccountIds());
            $currencyRate = $this->rateRepository->findById($accountSrc->getCurrency(), $accountDst->getCurrency());
            $exchangeBuilder = new ExchangeExchangeBuilder($currencyRate, $accountSrc, $accountDst, $exchangeDto->amount);
            $this->calculateManager->setBuilder($exchangeBuilder);
            $this->calculateManager->exchange();
            $accountSrc->setAmount($exchangeBuilder->getSrcAmount()->getAmount());
            $accountDst->setAmount($exchangeBuilder->getDstAmount()->getAmount());
            $this->accountRepository->save();
        } catch (\Throwable $e) {
            throw new ServiceException($e->getMessage());
        }

    }
}