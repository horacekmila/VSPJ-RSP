<?php


namespace App\Command;


use App\Entity\Article;
use App\Entity\Role;
use App\Entity\State;
use App\Entity\StateGroup;
use App\Entity\User;
use App\Enum\ArticleEnums;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitApplicationCommand extends Command
{
    protected static $defaultName = 'app:init-app';

    private const USERNAME = 'root';
    private const PASSWORD = 'password';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct(null);
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $adminRole = $this->createRoles();
            $root = $this->createRoot($adminRole);
            $states = $this->createStates();
            $this->createArticles($states, $root);
        } catch(\Exception $e) {
            dd($e);
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    private function createRoot(Role $role): User
    {
        $user = (new User())
            ->setFirstname(self::USERNAME)
            ->setLastname('rootovič')
            ->setPassword(self::PASSWORD)
            ->addRole($role);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    private function createRoles(): Role
    {
        $role = (new Role())
            ->setName("ROLE_ADMIN")
            ->setAlias("Administrátor");

        $this->entityManager->persist($role);
        $this->entityManager->flush();
        return $role;
    }

    /**
     * @return State[]
     */
    private function createStates(): array
    {
        $stateWIP = (new State())
            ->setName(ArticleEnums::WIP);


        $stateSubmited = (new State())
            ->setName(ArticleEnums::SUBMITED);

        $this->entityManager->persist($stateSubmited);

        $stateGroup = (new StateGroup())
            ->addNextState($stateSubmited);

        $this->entityManager->persist($stateGroup);
        $stateWIP->setNextStateGroup($stateGroup);

        $this->entityManager->persist($stateWIP);

        $this->entityManager->flush();

        return [
            "WIP" => $stateWIP,
            "Submited" => $stateSubmited
        ];
    }



    /** Tohle dej do dummy data commandu
     * @param array $states
     * @param User $root
     * @return Article[]
     */
    private function createArticles(array $states, User $root): array
    {
        $article = (new Article())
            ->setTitle('Test #1')
            ->setContent('Default content')
            ->setAssigne($root)
            ->setState($states[ArticleEnums::WIP])
            ->setIsActive(true)
            ->setEditable(true)
            ->setVersion(1)
            ->setCreatedBy($root);

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return [$article];
    }
}