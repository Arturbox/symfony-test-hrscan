<?php

namespace App\Factory;

use App\Dto\AccountDto;
use App\Entity\Account;

class AccountFactory
{

    public static function create(AccountDto $accountDto): Account
    {
        $account = new Account();
        $account->setAmount($accountDto->amount)->setCurrency($accountDto->currency);
        return $account;
    }
}