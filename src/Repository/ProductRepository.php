<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws NoResultException
     */
    public function requireOneWithCurrencyById(int $id): Product
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->select('p', 'currency')
            ->innerJoin('p.currency', 'currency')
            ->andWhere('p.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }
}
