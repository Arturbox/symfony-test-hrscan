<?php

namespace App\ValueResolver;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CurrencyValueResolver implements ValueResolverInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Currency::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (strlen($request->getContent())) {
            $parameters = $request->toArray();
            if (array_key_exists('currency_id', $parameters)) {
                $currency = $this->entityManager->getRepository(Currency::class)->find($parameters['currency_id']);
                if ($currency) {
                    yield $currency;
                }
            }
        }
    }

}
