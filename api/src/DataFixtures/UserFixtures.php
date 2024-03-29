<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\HousingProperties;
use App\Entity\Housing;
use App\Entity\RealEstateAd;
use Faker\Factory;

class UserFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $admin = new User();
        $admin->setFirstname('Admin');
        $admin->setLastname('Test');
        $admin->setBirthdate(new \DateTime('1990-01-01'));
        $admin->setEmail('admin@example.com');
        $admin->setPassword('$2y$13$Ab1A2/einqjW6NrtAlX8EeBAej4NLTTO1UizZO1ZSiwfYCuBErSva');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsActive(true);
        $manager->persist($admin);

        $owner = new User();
        $owner->setFirstname('Owner');
        $owner->setLastname('Test');
        $owner->setBirthdate(new \DateTime('1990-01-01'));
        $owner->setEmail('owner@example.com');
        $owner->setPassword('$2y$13$7e9DOBlB2IKqX8AZchI.Ze6UveF5XcBUwwTpBaJWo5lfc10BqdRpW');
        $owner->setRoles(['ROLE_OWNER']);
        $owner->setIsActive(true);
        $manager->persist($owner);

        $user = new User();
        $user->setFirstname('User');
        $user->setLastname('Test');
        $user->setBirthdate(new \DateTime('1990-01-01'));
        $user->setEmail('user@example.com');
        $user->setPassword('$2y$13$tIws.jl8f3de/iQNUI1O4.24v2E7kPuVIZiY2TgcJkA5E7NNGJQqm');
        $user->setRoles(['ROLE_USER']);
        $user->setIsActive(true);
        $manager->persist($user);


        /**
         * HOUSINGS
         */
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($this->generateRandomString() . '@example.com');
            $user->setPassword('$2y$13$Ab1A2/einqjW6NrtAlX8EeBAej4NLTTO1UizZO1ZSiwfYCuBErSv');
            $user->setRoles(['ROLE_OWNER']);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setBirthdate(new \DateTime('1990-01-01'));
            $user->setIsActive(true);
            $manager->persist($user);

            $housingProperties = new HousingProperties();
            $housingProperties->setSurface($faker->numberBetween(20, 500));
            $housingProperties->setType($faker->randomElement(['house', 'apartment']));
            $housingProperties->setRooms($faker->numberBetween(1, 10));
            $housingProperties->setHasGarden($faker->boolean);
            $housingProperties->setHasParking($faker->boolean);
            $housingProperties->setHasPool($faker->boolean);
            $housingProperties->setHasAttic($faker->boolean);
            $housingProperties->setHasCave($faker->boolean);
            $housingProperties->setHasBalcony($faker->boolean);
            $housingProperties->setNearPublicTransport($faker->boolean);
            $housingProperties->setClassification($faker->randomElement(['excellent', 'good', 'average', 'bad', 'insalubrious']));
            $manager->persist($housingProperties);

            $housing = new Housing();
            $housing->setAddress($faker->streetAddress);
            $housing->setAddress2($faker->secondaryAddress);
            $housing->setZipcode($faker->postcode);
            $housing->setCity($faker->city);
            $housing->setLat($faker->randomFloat(6, 43.5, 44.5));
            $housing->setLng($faker->randomFloat(6, 1.5, 2.5));
            $housing->setDoor($faker->randomElement(['left', 'right']));
            $housing->setFloor($faker->numberBetween(0, 10));
            $housing->setProperties($housingProperties);
            $housing->setOwner($user);
            $manager->persist($housing);

            $realEstateAd = new RealEstateAd();
            $realEstateAd->setType($faker->randomElement(['rent', 'sale']));
            $realEstateAd->setPrice($faker->numberBetween(100, 1000000));
            $realEstateAd->setTitle($faker->sentence(6, true));
            $realEstateAd->setDescription($faker->paragraph(30, true));
            $randomNumber = $faker->numberBetween(5, 20);
            $photos = [];
            for ($j = 0; $j < $randomNumber; $j++) {
                $photos[] = $faker->imageUrl(640, 480, 'housing', true, false);
            }
            $realEstateAd->setPhotos($photos);
            $realEstateAd->setHousing($housing);
            $realEstateAd->setPublisher($user);
            $realEstateAd->setIsVisible(true);
            $manager->persist($realEstateAd);
        }

        $manager->flush();
    }

    // Function that generate random string
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
