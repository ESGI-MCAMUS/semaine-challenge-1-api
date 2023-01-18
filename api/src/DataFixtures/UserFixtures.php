<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $admin = new User();
        $admin->setFirstname('Admin');
        $admin->setLastname('Test');
        $admin->setBirthdate(new \DateTime('1990-01-01'));
        $admin->setEmail('admin@example.com');
        $admin->setPassword('$2y$13$Ab1A2/einqjW6NrtAlX8EeBAej4NLTTO1UizZO1ZSiwfYCuBErSva');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $owner = new User();
        $owner->setFirstname('Owner');
        $owner->setLastname('Test');
        $owner->setBirthdate(new \DateTime('1990-01-01'));
        $owner->setEmail('owner@example.com');
        $owner->setPassword('$2y$13$7e9DOBlB2IKqX8AZchI.Ze6UveF5XcBUwwTpBaJWo5lfc10BqdRpW');
        $owner->setRoles(['ROLE_OWNER']);
        $manager->persist($owner);

        $user = new User();
        $user->setFirstname('User');
        $user->setLastname('Test');
        $user->setBirthdate(new \DateTime('1990-01-01'));
        $user->setEmail('user@example.com');
        $user->setPassword('$2y$13$tIws.jl8f3de/iQNUI1O4.24v2E7kPuVIZiY2TgcJkA5E7NNGJQqm');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
