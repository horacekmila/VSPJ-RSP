<?php


namespace App\Controller;


use App\Entity\Role;
use App\Entity\User;
use App\Enum\RoleEnums;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    /**
     *
     * @Route("/user/create", name="app_user_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->hasRole(RoleEnums::ROLE_ADMIN))
        {
            // @copyright Miloslav Horáček, veškeré úpravy musí být konzultovány. Dle https://www.zakonyprolidi.cz/cs/2000-121
            return $this->redirect("https://www.pornhub.com/view_video.php?viewkey=ph5e9b22ae1ce88");
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user)
            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'multiple' => true,
                'choice_label' => 'alias'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Odeslat']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $datetime = new \DateTime();

            $user->setCreatedAt($datetime);
            $user->setUpdatedAt(null);
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', sprintf('Uživatel s ID %s byl úspěšně založen.', $user->getId()));

            return $this->redirectToRoute('articles_list');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/update", name="app_user_update")
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user)
            ->add('submit', SubmitType::class, ['label' => 'Odeslat']);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $dateTime = new \DateTime();

            $user->setUpdatedAt($dateTime);
            $this->em->flush();

            $this->addFlash('success', sprintf('Uživatel s ID %s byl úspěšně upraven.', $user->getId()));

            return $this->redirectToRoute('articles_list');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}