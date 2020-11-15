<?php

namespace App\Repository;

use App\Entity\ReviewCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReviewCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReviewCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReviewCategory[]    findAll()
 * @method ReviewCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReviewCategory::class);
    }

    // /**
    //  * @return ReviewCategory[] Returns an array of ReviewCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReviewCategory
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
