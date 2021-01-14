<?php


namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Article;
use App\Entity\Review;
use App\Entity\Role;
use App\Entity\User;
use App\Enum\RoleEnums;
use App\Enum\StateEnums;
use App\Repository\ArticleRepository;
use App\Repository\ReviewCategoryRepository;
use App\Repository\ReviewRepository;
use App\Repository\StateRepository;
use App\Repository\UserRepository;
use App\Service\ArticleService;
use DateTime;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ArticleType;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("article")
 * @Route("article")
 */
class ArticleController extends AbstractController
{
    private StateRepository $stateRepository;

    private EntityManagerInterface $entityManager;

    private ArticleRepository $articleRepository;

    private ArticleService $articleService;

    private UserRepository $userRepository;

    private ReviewCategoryRepository $reviewCategoryRepository;

    private ReviewRepository $reviewRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        ArticleService $articleService,
        StateRepository $stateRepository,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        ReviewCategoryRepository $reviewCategoryRepository,
        ReviewRepository $reviewRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
        $this->stateRepository = $stateRepository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->reviewCategoryRepository = $reviewCategoryRepository;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * @Route("/list", name="articles_list")
     * @return Response
     */
    public function list(): Response
    {
        $assignedArticles = $this->articleService->getArticlesByRole($this->getUser());
        $otherArticles = $this->articleService->getArticlesExclude($assignedArticles);
        $users = $this->userRepository->findAll();
        $reviewCategories = $this->reviewCategoryRepository->findAll();

        $redactors = [];
        foreach($users as $user)
        {
            if ($user->hasRole(RoleEnums::ROLE_REVIEWER))
            {
                $redactors[] = $user;
            }
        }

        return $this->render("article/article.list.html.twig", [
            "assignedArticles" => $assignedArticles,
            "otherArticles" => $otherArticles,
            "redactors" => $redactors,
            "reviewCategories" => $reviewCategories
        ]);
    }

    /**
     * @Route("/view/{article}", name="article_view")
     * @param Article $article
     * @return Response
     */
    public function view(Article $article)
    {
        $reviews = $this->reviewRepository->findBy(["article" => $article]);

        return $this->render('article/article.view.html.twig', [
            'article' => $article,
            'reviews' => $reviews,
            'categories' => $this->reviewCategoryRepository->findAll(),
            'comments' => $article->getAnswers()
        ]);
    }

    /**
     * @Route("/odeslat-komentar", name="komtar")
     */
    public function sendComments(Request $request)
    {
        $body = $request->getContent();
        $post = json_decode($body)->gomment;
        $article = json_decode($body)->article;

        $answer = new Answer();
        $answer->setDescription($post)
            ->setArticle($this->articleRepository->find($article))
            ->setAuthor($this->getUser())
            ->setQuestion(null);
        $this->entityManager->persist($answer);
        $this->entityManager->flush();

        return $this->json("x");
    }

    /**
     * @Route("/list/{article}/edit", name="article_edit")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request, SluggerInterface $slugger)
    {
        $oldArticle = $article;
        $form = $this->createForm(ArticleType::class)
            ->add("content", FileType::class)
            ->add("submit", SubmitType::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();
            $contentFile = $form->get('content')->getData();
            if ($contentFile) {
                $originalFilename = pathinfo($contentFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$contentFile->guessExtension();

                try {
                    $contentFile->move(
                        PUBLIC_FOLDER,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $oldArticle->setTitle($article["title"]);
                $oldArticle->setContent($newFilename);
            }
            $this->entityManager->persist($oldArticle);
            $this->entityManager->flush();

            $this->addFlash('success', 'Article Edited!');

            return $this->redirectToRoute('articles_list');
        }

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
        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("/list/{article}/return", name="article_return")
     * @param Article $article
     * @return Response
     */
    public function returnToWriter(Article $article)
    {
        $submittedState = $this->stateRepository->findOneBy(["name" => StateEnums::INAPPROPRIAT_THEME]);
        $author = $article->getCreatedBy();
        $article
            ->setState($submittedState)
            ->setAssigne($this->userRepository->find($author));

        $this->entityManager->flush();
        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("/list/{article}/public", name="article_public")
     * @param Article $article
     * @return Response
     */
    public function public(Article $article)
    {
        $submittedState = $this->stateRepository->findOneBy(["name" => StateEnums::SENT]);
        $article
            ->setState($submittedState)
            ->setIsActive(true);

        $this->entityManager->flush();
        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("/submit/to-review", name="article_submit_to_review")
     * @return Response
     */
    public function review(Request $request)
    {
        $body = $request->getContent();
        $requestData = json_decode($body);

        try {
            $article = $this->articleRepository->find($requestData->article);
            $user = $this->userRepository->find($requestData->redactor);
        } catch(\Exception $e) {
            return $this->json(["response" => $e->getMessage()]);
        }
        $inReview = $this->stateRepository->findOneBy(["name" => StateEnums::IN_REVIEW]);
        $article->setState($inReview);
        $article->setAssigne($user);
        $this->entityManager->flush();
        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("/list/{article}/delete", name="article_delete")
     * @param Article $article
     * @return Response
     */
    public function delete(Article $article)
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();
        return $this->redirectToRoute('articles_list');
    }

    /**
     * @Route("/new", name="article_new")
     * @param Request $request
     * @param StateRepository $states
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function new(Request $request, StateRepository $states, SluggerInterface $slugger)
    {
        $states = $this->stateRepository->findAll();
        $stateArray = [];
        foreach($states as $state) {
            $stateArray[$state->getName()] = $state;
        }
        /** @var User $user */
        $user = $this->getUser();

        $newArticle = (new Article())
            ->setTitle('')
            ->setContent('')
            ->setAssigne($user)
            ->setState($stateArray[StateEnums::WORK_IN_PROGRESS])
            ->setIsActive(false)
            ->setEditable(true)
            ->setVersion(1)
            ->setCreatedBy($user);

        $form = $this->createForm(ArticleType::class, $newArticle)
            ->add("content", FileType::class)
            ->add("submit", SubmitType::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newArticle = $form->getData();
            $contentFile = $form->get('content')->getData();
            if ($contentFile) {
                $originalFilename = pathinfo($contentFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$contentFile->guessExtension();

                try {
                    $contentFile->move(
                        PUBLIC_FOLDER,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $newArticle->setContent($newFilename);
            }

            $this->entityManager->persist($newArticle);
            $this->entityManager->flush();

            $this->addFlash('success', 'Article Edited!');

            return $this->redirectToRoute('articles_list');
        }

        return $this->render('article/article.edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("create/review", name="create_review")
     */
    public function createReview(Request $request)
    {
        $categories = $this->reviewCategoryRepository->findAll();

        $body = json_decode($request->getContent());
        $review = new Review();
        $review->setArticle($this->articleRepository->find($body->article))
            ->setDescription($body->comment)
            ->setCreatedAt(new DateTime());
        foreach($categories as $category) {
            $review->addCategory($category);
            $review->setCategory1Rating($body->category_1);
            $review->setCategory2Rating($body->category_2);
            $review->setCategory3Rating($body->category_3);
            $review->setCategory4Rating($body->category_4);
            $review->setCategory5Rating($body->category_5);
        }
        try {
            $this->entityManager->persist($review);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            return $this->json($e->getMessage());
        }
        return $this->json("yo");
    }

    /**
     * @Route("/new_user", name="user_new")
     * @param Request $request
     * @return Response
     */
    public function newUser(Request $request)
    {
        $body = $request->getContent();
        $firstname = json_decode($body)->firstname;
        $lastname = json_decode($body)->lastname;
        $middlename = json_decode($body)->middlename;
        $password = json_decode($body)->password;

        $newUser = (new User())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setMiddlename($middlename)
            ->setCreatedAt(new DateTime())
            ->setPassword($password);
        try {
            $this->entityManager->persist($newUser);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            return $this->json($e->getMessage());
        }
        return $this->json("yo");
    }

}