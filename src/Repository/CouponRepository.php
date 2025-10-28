<?php

namespace App\Repository;

use App\Entity\Coupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupon>
 */
class CouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    /**
     * @throws NoResultException
     */
    public function requireOneByCode(string $code): Coupon
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
