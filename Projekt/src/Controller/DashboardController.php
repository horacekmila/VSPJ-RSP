<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /** @Route("/",name="app_main") */
    public function firstpage(): Response
    {
        $articles = $this->articleRepository->findAll();
        return $this->render("mainPage/firstpage.html.twig", [
            "articles" => $articles
        ]);
    }
    /** @var ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /** @Route("/dashbord",name="app_dashboard") */
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();
        return $this->render("dashboard.html.twig" , [
            "articles" => $articles
        ]);
    }
}