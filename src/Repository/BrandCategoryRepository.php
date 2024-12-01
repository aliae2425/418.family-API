<?php

namespace App\Repository;

use App\Entity\BrandCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrandCategory>
 */
class BrandCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrandCategory::class);
    }

    public function index()
    {
        return $this->createQueryBuilder('bc')
            ->select('NEW App\\DTO\\Admin\\BrandCategoryIndexDTO(bc.id, bc.name, COUNT(c))')
            ->leftJoin('bc.brands', 'c')
            ->groupBy('bc.id')
            ->getQuery()
            ->getResult();
    }

}
