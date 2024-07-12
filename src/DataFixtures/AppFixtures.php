<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Categories;
use App\Entity\Publisher;
use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
        $this->faker = Factory::create('fr_FR');
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

        for ($i = 0; $i < 10; $i++) {
            $user = (new Users)
                ->setUsername($this->faker->userName())
                ->setEmail($this->faker->unique()->email())
                ->setRoles(['ROLE_USER'])
                ->setEnable($this->faker->boolean(70))
                ->setPassword($this->hasher->hashPassword(new Users, 'Test1234!'));

            $manager->persist($user);
        }

        for ($i = 0; $i < 5; $i++) {
            $author = (new Author)
                ->setName($this->faker->lastName())
                ->setFirstName($this->faker->firstName());

            $manager->persist($author);
        }

        for ($i = 0; $i < 5; $i++) {
            $publisher = (new Publisher)
                ->setName($this->faker->name());


            $manager->persist($publisher);
        }
        $categories = ['Science-fiction', 'Romance', 'Fantastique', 'Thriller', 'Policier', 'Jeunesse', 'Anticipation', 'Aventure', 'Voyage', 'Biographie'];
        foreach ($categories as $categorieName) {
            $categorie = (new Categories)
                ->setTitle($categorieName);

            $manager->persist($categorie);

            $categoriesFinal[] = $categorie;
        }

        $manager->flush();
    }
}
