<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Country>
 */
class CountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    /**
     * @throws NoResultException
     */
    public function requireOneByCode(string $code): Country
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c')
            ->andWhere('c.code = :code')
            ->setMaxResults(1)
            ->setParameter('code', $code);

        return $qb->getQuery()->getSingleResult();
    }
}
