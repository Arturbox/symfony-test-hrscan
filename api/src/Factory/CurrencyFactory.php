<?php

namespace App\Factory;

use App\Dto\CurrencyDto;
use App\Entity\Currency;

class CurrencyFactory
{

    public static function create(CurrencyDto $currencyDto): Currency
    {
        $currency = new Currency();
        $currency->setName($currencyDto->name)->setCode($currencyDto->code);
        return $currency;
    }


}