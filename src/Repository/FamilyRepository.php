<?php

namespace App\Repository;

use App\Entity\Family;
use App\Entity\FamilyCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Family>
 */
class FamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Family::class);
    }

    public function findAllPaginated(int $page, int $limit)
    {
        $query = $this->createQueryBuilder('f')
            ->getQuery();

        return $this->paginator->paginate($query, $page, $limit);
    }

    public function searchPaginated(int $page, int $limit, string $search)
    {
        $query = $this->createQueryBuilder('f')
            ->where('f.name LIKE :search')
            ->setParameter('search', "%$search%")
            ->getQuery();

        return $this->paginator->paginate($query, $page, $limit);
    }

       public function findByPaginate(FamilyCategory $value, int $page, int $limit)
       {
           $query = $this->createQueryBuilder('f')
               ->andWhere('f.familyCategory = :val.id')
               ->setParameter('val', $value)
               ->orderBy('f.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
           return $this->paginator->paginate($query, $page, $limit);
       }

    //    public function findOneBySomeField($value): ?Family
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
