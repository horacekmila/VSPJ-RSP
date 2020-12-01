<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\Article;
use App\Enum\RoleEnums;
use App\Enum\StateEnums;
use App\Repository\ArticleRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param UserInterface $user
     * @return Article[]
     */
    public function getArticlesByRole(UserInterface $user): array
    {
        if ($user->hasRole(RoleEnums::ROLE_WRITER) || $user->hasRole(RoleEnums::ROLE_REVIEWER)) {
            return $this->articleRepository->findBy(["assigne" => $user]);
        }
        if ($user->hasRole(RoleEnums::ROLE_EDITOR)) {
            return $this->articleRepository->findExcludeStates([StateEnums::WORK_IN_PROGRESS, StateEnums::INAPPROPRIAT_THEME]);
        }
        return [];
    }

    /**
     * @param Article[] $articles
     * @return Article[]
     */
    public function getArticlesExclude(array $articles): array
    {
        if (empty($articles)) {
            return $this->articleRepository->findAll();
        }
        $ids = [];
        foreach($articles as $article) {
            $ids[] = $article->getId();
        }
        return $this->articleRepository->findExcludeIds($ids);
    }
}