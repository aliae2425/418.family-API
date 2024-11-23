<?php

namespace App\Repository;

use App\Entity\Fabricant;
use App\DTO\BrandsIndexDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fabricant>
 */
class FabricantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fabricant::class);
    }


    /**
     * @return BrandsIndexDTO[]
     */
    public function adminIndex(): array
    {
        return $this->createQueryBuilder('b')
            ->select('NEW App\\DTO\\Admin\\BrandsIndexDTO(b.id, b.name, c.name, COUNT(l), COUNT(f))')
            ->leftJoin('b.category', 'c')
            ->leftJoin('b.lien', 'l')
            ->leftJoin('b.families', 'f')
            ->groupBy('b.id')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Fabricant[] Returns an array of Fabricant objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fabricant
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
