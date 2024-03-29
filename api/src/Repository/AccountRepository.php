<?php

namespace App\Repository;

use App\Entity\Account;
use App\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $manager)
    {
        parent::__construct($registry, Account::class);
    }

    public function create(Account $account): Account
    {
        $this->manager->persist($account);
        $this->manager->flush();

        return $account;
    }

    public function save(): void
    {
        $this->manager->flush();
    }

    public function delete(Account $account): Account
    {
        $this->manager->remove($account);
        $this->manager->flush();

        return $account;
    }


    public function findById(int $id): Account
    {
        if ($data = $this->findOneBy(["id" => $id])) {
            return $data;
        } else {
            throw new NotFoundException('Account', $id);
        }
    }

    public function findMultipleIds(array $ids): array
    {
        $accounts = $this->findBy(["id" => $ids]);

        if (count($accounts) != count($ids)) {
            throw new NotFoundException('Account', $ids);
        }

        usort($accounts, function (Account $a, Account $b) use ($ids) {
            $pos_a = array_search($a->getId(), $ids);
            $pos_b = array_search($b->getId(), $ids);
            return $pos_a - $pos_b;
        });

        return $accounts;
    }


}
