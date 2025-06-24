<?php

namespace App\DataFixtures;

use App\Entity\Laundry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $laundry = new Laundry();
        $laundry->setName('Laundry');
        $laundry->setEmail('contact@laundry.com');
        $laundry->setPhone('1234567890');
        $laundry->setCreatedAt(new \DateTime());
        $manager->persist($laundry);

        $manager->flush();
    }
}
