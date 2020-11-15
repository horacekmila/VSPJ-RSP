<?php

namespace App\Repository;

use App\Entity\StateGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StateGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method StateGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method StateGroup[]    findAll()
 * @method StateGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StateGroup::class);
    }

    // /**
    //  * @return StateGroup[] Returns an array of StateGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StateGroup
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
