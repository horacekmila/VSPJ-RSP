<?php


namespace App\Service;


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
        return $this->articleRepository->findBy(["assigne" => $user]);
    }

    /**
     * @param Article[] $articles
     * @return array
     */
    public function getArticlesExcluding(array $articles): array
    {
        return $this->articleRepository->findExclArticles($articles);
    }
}