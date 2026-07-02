<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct( private UserPasswordHasherInterface $passwordHasher)
    {
   
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin12345'));

        $client = new User();
        $client->setEmail('client@gmail.com');
        $client->setRoles(['ROLE_CLIENT']);
        $client->setIsVerified(true);
        $client->setPassword($this->passwordHasher->hashPassword($client, 'client12345'));

        $manager->persist($admin);
        $manager->persist($client);

        $manager->flush();
    }
}
