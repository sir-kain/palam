<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $password = $this->hasher->hashPassword($user, 'passer');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('user@user.com');
        $password = $this->hasher->hashPassword($user1, 'passer');
        $user1->setPassword($password);
        $manager->persist($user1);

        $manager->flush();
    }
}
