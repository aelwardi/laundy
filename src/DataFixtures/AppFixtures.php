<?php

namespace App\DataFixtures;

use App\Entity\Laundry;
use App\Entity\Section;
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

        $section = new Section();
        $section->setTitle('Réinventer l\'avenir de la laverie et du pressing.');
        $section->setImage('img5.png');
        $section->setDescription('Laundryheap fournit le service de laverie et de pressing professionnel le plus rapide, le plus facile à utiliser et le plus fiable. Notre service s\'adapte parfaitement à vos besoins.
        Nous collectons, nettoyons et livrons votre linge à votre domicile. Nous serons là, où et quand vous en aurez besoin. 98,7 % de tous les services de laverie et pressing standards sont livrés le lendemain.');
        $section->setLaundry($laundry);
        $manager->persist($section);

        $section1 = new Section();
        $section1->setTitle('Qui sommes nous ?');
        $section1->setImage('img6.png');
        $section1->setDescription('Fondée en 2014 à Londres, Laundryheap est l\'entreprise de laverie et de pressing de nouvelle génération.
        Nous proposons des services de laverie, de blanchisserie et de pressing professionnels livrés à votre porte en 24 heures seulement.
        
        Nous sommes disponibles dans le monde entier
        Depuis nos débuts à Londres, nous nous sommes étendus à 14 différents pays du monde entier. Nos services sont disponibles dans les pays suivants : Denmark, Kuwait, Ireland, Qatar, Singapore, Sweden, UAE, United States, United Kingdom, Peru, Bahrain, Netherlands, France et Saudi Arabia.
        
        Nous sommes disponibles dans le monde entier
        La durabilité sociale et environnementale est au cœur de nos activités. Nous construisons la plus grande flotte de véhicules de livraison électriques et nous nous engageons à réduire la consommation d\'eau, d\'électricité et la quantité des emballages.');
        $section1->setLaundry($laundry);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setTitle('Qualité sans compromis.');
        $section2->setImage('img7.png');
        $section2->setDescription('Nous travaillons en partenariat avec des partenaires locaux de nettoyage et de livraison soigneusement sélectionnés pour garantir que vos articles soient traités avec le plus grand soin.
        Nous ne faisons jamais de compromis en matière de qualité et de rapidité. Nous rémunérons équitablement nos chauffeurs partenaires et sommes fiers de travailler avec des dizaines de services de nettoyage locaux fiables afin de minimiser les transports.');
        $section2->setLaundry($laundry);
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setTitle('La croissance, la durabilité et l\'expansion font partie intégrante de relations solides avec les clients.');
        $section3->setImage('img8.png');
        $section3->setDescription('Deyan Dimitrov, PDG de Laundryheap');
        $section3->setLaundry($laundry);
        $manager->persist($section3);

        $manager->flush();
    }
}
