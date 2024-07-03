<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = (new Users)
            ->setUsername('Admin')
            ->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword(new Users, 'Test1234!'))
            ->setEnable('1');

        $manager->persist($user);

        $user = (new Users)
            ->setUsername('User1')
            ->setEmail('user1@test.com')
            // ->setRoles(['ROLE_USER'])
            ->setEnable('1')
            ->setPassword($this->hasher->hashPassword(new Users, 'Test1234!'));

        $manager->persist($user);

        $manager->flush();
    }
}
