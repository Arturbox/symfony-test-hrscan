<?php

namespace App\Tests;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;

class ParentController extends WebTestCase
{

    public function getAuthorizedClient(): KernelBrowser|AbstractBrowser|null
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(ClientRepository::class);
        $testUser = $userRepository->findOneByEmail('test@gmail.com');
        $client->loginUser($testUser);

        return $client;
    }

    public function getNoAuthClient(): KernelBrowser|AbstractBrowser|null
    {
        return static::createClient();
    }

}