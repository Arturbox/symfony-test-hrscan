<?php

namespace App\EventListener;

use App\Entity\Account;
use App\Entity\Client;
use Symfony\Bundle\SecurityBundle\Security;

class AccountClientIdListener
{
    public function __construct(private Security $security)
    {
    }

    public function prePersist($entity): void
    {
        /** @var Client $client */
        if ($client = $this->security->getUser()){
            if ($entity instanceof Account) {
                $entity->setClient($client);
            }
        }
    }

}