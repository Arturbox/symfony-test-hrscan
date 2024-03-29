<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ClientScopeSubscriber extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        if ($targetEntity->hasAssociation('client') && $this->hasParameter('auth_id')) {
            if ($authId = $this->getParameter('auth_id')) {
                return $targetTableAlias . '.client_id = ' . $authId;
            }
        }

        return '';
    }
}
