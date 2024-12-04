<?php

namespace App\Repository;

use App\Entity\Brands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brands>
 */
class BrandsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brands::class);
    }

    public function index()
    {
        return $this->createQueryBuilder('b')
            ->select('NEW App\\DTO\\Admin\\BrandIndexDTO(b.id, b.name, c, b._createAt, b._updateAt, COUNT(l))')
            ->innerJoin('b.categories', 'c')
            // ->innerJoin('o.group', 't')
            ->leftJoin('b.links', 'l')
            ->groupBy('b.id')
            ->getQuery()
            ->getResult();
    }
}
