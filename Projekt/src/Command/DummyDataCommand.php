<?php


namespace App\Command;


use App\Enum\RoleEnums;
use App\Enum\StateEnums;
use App\Entity\Article;
use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Console\Command\Command;
use App\Repository\UserRepository;
use App\Repository\StateRepository;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DummyDataCommand extends Command
{
    protected static $defaultName = 'import:dummy-data';

    private $entityManager;

    private $userRepository;

    private $stateRepository;

    private $roleRepository;

    public function __construct(
     EntityManagerInterface $entityManager,
     UserRepository $userRepository,
     StateRepository $stateRepository,
     RoleRepository $roleRepository
     ) {
        parent::__construct(null);
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $states = $this->stateRepository->findAll();
        $stateArray = [];
        foreach($states as $state) {
            $stateArray[$state->getName()] = $state;
        }

        $root = $this->userRepository->findOneBy(["firstname" => InitApplicationCommand::USERNAME]);
        $users = $this->createUsers();
        $this->createArticles($stateArray, $users, $root);

        return Command::SUCCESS;
    }

    /**
    * @param State[] $states
    * @param User[] $users
    * @param User $root
    * @return Article[]
    */
    private function createArticles(array $states, array $users, User $root): array
    {
        $articleEditor = (new Article())
            ->setTitle('Test #1')
            ->setContent('Default content')
            ->setAssigne($users[RoleEnums::ROLE_EDITOR])
            ->setState($states[StateEnums::SUBMITTED])
            ->setIsActive(true)
            ->setEditable(false)
            ->setVersion(1)
            ->setCreatedBy($users[RoleEnums::ROLE_EDITOR]);

        $articleWriter = (new Article())
            ->setTitle('Test #2')
            ->setContent('Default content')
            ->setAssigne($users[RoleEnums::ROLE_WRITER])
            ->setState($states[StateEnums::WORK_IN_PROGRESS])
            ->setIsActive(true)
            ->setEditable(true)
            ->setVersion(1)
            ->setCreatedBy($users[RoleEnums::ROLE_WRITER]);


        $this->entityManager->persist($articleEditor);
        $this->entityManager->persist($articleWriter);
        $this->entityManager->flush();

        return [$articleWriter, $articleEditor];
    }

    /**
     * @return User[]
    */
    private function createUsers(): array
    {
        $roles = $this->roleRepository->findAll();
        $users = [];

        foreach($roles as $role) {
            $user = (new User())
                ->setFirstname($role->getAlias())
                ->setLastname($role->getAlias()."vič")
                ->setPassword('password')
                ->addRole($role);
            $this->entityManager->persist($user);
            $users[$role->getName()] = $user;
        }
        $this->entityManager->flush();
        return $users;
    }
}