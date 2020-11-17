<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleService
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param UserInterface $user
     * @return Article[]
     */
    public function getAssignedArticles(UserInterface $user): ?array
    {
        //TODO: again typo, double e => assignee
        return $this->articleRepository->findBy(["assigne" => $user]);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getNotAssignedArticles(User $user): array
    {
        return $this->articleRepository->findNotAssignedArticles($user);
    }
}