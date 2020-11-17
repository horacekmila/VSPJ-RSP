<?php


namespace App\Command;


use App\Entity\Article;
use App\Entity\Role;
use App\Entity\State;
use App\Entity\StateGroup;
use App\Entity\User;
use App\Enum\StateEnums;
use App\Enum\RoleEnums;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitApplicationCommand extends Command
{
    protected static $defaultName = 'app:init-app';

    public const USERNAME = 'root';
    public const PASSWORD = 'password';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct(null);
        $this->entityManager = $entityManager;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $roles = $this->createRoles();
            $root = $this->createRoot($roles);
            $states = $this->createStates();
        } catch(\Exception $e) {
            dd($e);
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    /**
     * @param Role[] $roles
     * @return User
     */
    private function createRoot(array $roles): User
    {
        $user = (new User())
            ->setFirstname(self::USERNAME)
            ->setLastname(self::USERNAME."ovič")
            ->setPassword(self::PASSWORD)
            ->addRole($roles[RoleEnums::ROLE_ADMIN]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    /**
     * @return Role[]
     */
    private function createRoles(): array
    {
        $roleNames = RoleEnums::values();
        $roles = [];
        foreach($roleNames as $roleName) {
            $role = (new Role())
                ->setName($roleName)
                ->setAlias($roleName."OVIČ");
            $this->entityManager->persist($role);
            $roles[$role->getName()] = $role;
        }
        $this->entityManager->flush();

        return $roles;
    }

    /**
     * @return State[]
     */
    private function createStates(): array
    {
        $stateNames = StateEnums::values();
        $states = [];
        foreach($stateNames as $stateName) {
            $stateObject = (new State())
                ->setName($stateName);
            $states[$stateObject->getName()] = $stateObject;
            $this->entityManager->persist($stateObject);
        }
        $this->entityManager->flush();
        return $states;
    }
}