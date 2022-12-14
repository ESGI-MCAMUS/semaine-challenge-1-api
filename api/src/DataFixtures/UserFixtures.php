<?php

namespace App\DataFixtures;

use App\Entity\Joke;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $pwd = '$2y$13$J5IdOLXFmW3MODsiWy38EufpneHTy2fpZt.zJrk/CPhDDq74JMIyK';

        $user = (new User())
            ->setEmail('user@user.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword($pwd)
        ;
        $manager->persist($user);

        $admin = (new User())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
        ;
        $manager->persist($admin);

        $moderator = (new User())
            ->setEmail('moderator@user.fr')
            ->setRoles(['ROLE_MODERATOR'])
            ->setPassword($pwd)
        ;
        $manager->persist($moderator);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
