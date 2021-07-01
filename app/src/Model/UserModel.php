<?php


namespace App\Model;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserModel
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordEncoderInterface $encoder
    ){}

    private function saveData(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function createNewUser(array $userInput): void
    {
        $user = new User();

        $user->setEmail($userInput['email']);
        $user->setRoles(['ROLE_USER']);
        $plainPassword = $userInput['password'];
        $encodedPassword = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);

        $this->saveData($user);
    }
}