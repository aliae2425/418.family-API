<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function findCurrentUserCart($user)
    {
        return $this->createQueryBuilder('c')
            ->setParameter('user', $user)
            ->where('c.validate = false')
            ->andWhere('c.user = :user')
            ->getQuery()
            ->getOneOrNullResult();
    }


}
