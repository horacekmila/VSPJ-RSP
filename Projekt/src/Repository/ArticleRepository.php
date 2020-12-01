<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param User $user
     * @return Article[]
     */
    public function findNotAssignedArticles(User $user): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->andWhere('a.assigne != :user')
            ->orWhere('a.assigne IS NULL')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string[] $states
     * @return Article[]
     */
    public function findExcludeStates(array $states): array
    {
        $qb = $this->createQueryBuilder("a");
        $qb->leftJoin(State::class, "s","with", 's.id = a.state')
            ->andWhere('s.name NOT IN (:states)')
            ->setParameter('states', $states);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int[] $ids
     * @return Article[]
     */
    public function findExcludeIds(array $ids): array
    {
        $qb = $this->createQueryBuilder("a");
        $qb->andWhere("a.id NOT IN (:ids)")
            ->setParameter("ids", $ids);

        return $qb->getQuery()->getResult();
    }
}
