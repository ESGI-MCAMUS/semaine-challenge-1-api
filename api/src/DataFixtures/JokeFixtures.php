<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Joke;
use App\Entity\Rate;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JokeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = $manager->getRepository(Category::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i=0; $i<50; $i++) {
            $object = (new Joke())
                ->setText($faker->paragraph)
                ->setAnswer($faker->paragraph)
                ->setAuthor($faker->randomElement($users))
            ;

            for ($y=0; $y<$faker->numberBetween(1, 15); $y++) {
                $object->addRate((new Rate())->setStar($faker->numberBetween(1, 5)));
            }

            for ($z=0; $z<3; $z++) {
                $object->addCategory($faker->randomElement($categories));
            }

            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}
