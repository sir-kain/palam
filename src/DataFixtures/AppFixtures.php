<?php

namespace App\DataFixtures;

use App\Entity\Responsable;
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
        $responsable1 = new Responsable();
        $responsable1->setLibelle('Equipe tech');
        $manager->persist($responsable1);

        $responsable2 = new Responsable();
        $responsable2->setLibelle('Equipe marketing');
        $manager->persist($responsable2);

        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setPrenom('Souleymane');
        $user->setNom('Ba');
        $password = $this->hasher->hashPassword($user, 'passer');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('user@user.com');
        $user1->setPrenom('Waly');
        $user1->setNom('Ndiaye');
        $password = $this->hasher->hashPassword($user1, 'passer');
        $user1->setPassword($password);
        $user1->setResponsable($responsable1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@user.com');
        $user2->setPrenom('Cheikh');
        $user2->setNom('Ndiaye');
        $password = $this->hasher->hashPassword($user2, 'passer');
        $user2->setPassword($password);
        $user2->setResponsable($responsable1);
        $manager->persist($user2);

        $manager->flush();
    }
}
