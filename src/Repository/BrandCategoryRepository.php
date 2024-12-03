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
            ->select('NEW App\\DTO\\Admin\\BrandCategoryIndexDTO(bc.id, bc.name, COUNT(b))')
            ->leftJoin('bc.brands', 'b')
            ->groupBy('bc.id')
            ->getQuery()
            ->getResult();
    }

    public function show(int $id)
    {
        return $this->createQueryBuilder('bc')
            ->select('bc', 'c')
            ->leftJoin('bc.brands', 'c')
            ->where('bc.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
