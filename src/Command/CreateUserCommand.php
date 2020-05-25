<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserCommand extends Command
{
    
    private $userPasswordEncoder;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    protected function configure()
    {
        $this->setName('app:user-default');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setUsername('admin');
        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setPassword($this->userPasswordEncoder->encodePassword($admin, 'admin'));
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
        return 0;
    }
}

?>