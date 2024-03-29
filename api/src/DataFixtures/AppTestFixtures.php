<?php

namespace App\DataFixtures;

use App\Dto\AccountDto;
use App\Dto\CurrencyDto;
use App\Entity\Client;
use App\Entity\CurrencyRate;
use App\Factory\AccountFactory;
use App\Factory\CurrencyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class AppTestFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $factory = new PasswordHasherFactory([
            'auto' => ['algorithm' => 'auto'],
        ]);
        $hasher = $factory->getPasswordHasher('auto');
        $clients = [];

        foreach (['test@gmail.com'] as $email) {
            $client = new Client();
            $client->setEmail($email);
            $client->setPassword($hasher->hash('aaaaaaaa'));
            $client->setRoles(['ROLE_USER']);
            $manager->persist($client);
            $clients[] = $client;
        }

        $currencies = [];

        foreach ([
                     'usd',
                     'euro',
                     'rub',
                 ] as $code) {
            $currency = CurrencyFactory::create(new CurrencyDto($code, $code));
            $manager->persist($currency);
            $currencies[$code] = $currency;
        }
        $manager->flush();

        foreach ($currencies as $k => $currency) {
            foreach (array_filter(
                         $currencies,
                         function ($key) use ($k) {
                             return $key != $k;
                         },
                         ARRAY_FILTER_USE_KEY
                     ) as $c) {
                $rate = new CurrencyRate();
                $rate->setRate(mt_rand(1, 1000));
                $rate->setSrc($currency);
                $rate->setDst($c);
                $manager->persist($rate);
            }
        }

        $manager->flush();

        $accountDto = new AccountDto($currencies['usd']->getId(), 1000);
        $accountDto->setCurrency($currencies['usd']);
        $currency = AccountFactory::create($accountDto);
        $currency->setClient($clients[0]);
        $manager->persist($currency);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            'test'
        ];
    }
}