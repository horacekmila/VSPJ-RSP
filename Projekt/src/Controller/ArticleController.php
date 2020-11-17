<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\State;
use App\Enum\StateEnums;
use App\Repository\ArticleRepository;
use App\Repository\StateRepository;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ArticleType;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("article", name="articles")
 * @Route("article")
 */
class ArticleController extends AbstractController
{

    /** @var StateRepository */
    private $stateRepository;

    /** @var EntityManagerInterface */
    private $entityManager;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var ArticleService
     */
    private $articleService;

    public function __construct(
        ArticleRepository $articleRepository,
        ArticleService $articleService,
        StateRepository $stateRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
        $this->stateRepository = $stateRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list", name="articles_list")
     * @return Response
     */
    public function list(): Response
    {
        $assignedArticles = $this->articleService->getAssignedArticles($this->getUser());
        $otherArticles = $this->articleService->getNotAssignedArticles($this->getUser());

        return $this->render("article/article.list.html.twig", [
            "assignedArticles" => $assignedArticles,
            "otherArticles" => $otherArticles
        ]);
    }

    /**
     * @Route("/view/{article}", name="article_view")
     * @param Article $article
     * @return Response
     */
    public function view(Article $article)
    {
        return $this->render('article/article.view.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/list/{article}/edit", name="article_edit")
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article)
    {
        $form = $this->createForm(ArticleType::class);
        return $this->render('article/article.edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/list/{article}/submit", name="article_submit")
     * @param Article $article
     * @return Response
     */
    public function submit(Article $article)
    {
        $submittedState = $this->stateRepository->findOneBy(["name" => StateEnums::SUBMITTED]);
        $article
            ->setState($submittedState)
            ->setAssigne(null);

        $this->entityManager->flush();
        return $this->render('article/article.submit.html.twig', [
            'article' => $article
        ]);
    }
}