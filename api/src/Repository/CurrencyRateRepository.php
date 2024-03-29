<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\CurrencyRate;
use App\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CurrencyRate>
 *
 * @method CurrencyRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyRate[]    findAll()
 * @method CurrencyRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $manager)
    {
        parent::__construct($registry, CurrencyRate::class);
    }


    public function findById(Currency $src, Currency $dst): CurrencyRate
    {
        if ($data = $this->findOneBy(['src' => $src, 'dst' => $dst])) {
            return $data;
        } else {
            throw new NotFoundException('CurrencyRate', [$src->getId(), $dst->getId()]);
        }
    }

}
