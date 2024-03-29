<?php

namespace App\EventListener;

use App\Entity\Client;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class OnRequestListener
{

    public function __construct(private EntityManagerInterface $entityManager, private TokenStorageInterface $tokenStorage)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $token = $this->tokenStorage->getToken();

        if ($token) {
            /** @var Client $user */
            $user = $token->getUser();
            if ($user) {
                $filter = $this->entityManager->getFilters()->enable('client_scope');
                $filter->setParameter('auth_id', $user->getId());
            }
        }
    }
}
