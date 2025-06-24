<?php

namespace App\DataFixtures;

use App\Entity\Laundry;
use App\Entity\Section;
use App\Entity\HowWorks;
use App\Entity\Step;
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

        $howWorks = new HowWorks();
        $howWorks->setIndice('Souple');
        $howWorks->setTitle('Planifiez votre collecte');
        $howWorks->setImage('img10.png');
        $howWorks->setRang(1);
        $howWorks->setDescription('Planifiez votre journée en toute simplicité. Choisissez un délai de collecte et de livraison qui vous convient.');
        $howWorks->setLaundry($laundry);
        $manager->persist($howWorks);

        $step = new Step();
        $step->setTitle('Réservez en ligne.');
        $step->setIcon('svg1.svg');
        $step->setRang(1);
        $step->setHowWork($howWorks);
        $howWorks->addStep($step);
        $manager->persist($step);

        $step1 = new Step();
        $step1->setTitle('Créneaux disponibles le week-end et le soir.');
        $step1->setIcon('svg2.svg');
        $step1->setRang(2);
        $step1->setHowWork($howWorks);
        $howWorks->addStep($step1);
        $manager->persist($step1);

        $howWorks1 = new HowWorks();
        $howWorks1->setIndice('Souple');
        $howWorks1->setTitle('Planifiez votre collecte');
        $howWorks1->setImage('img10.png');
        $howWorks1->setRang(2);
        $howWorks1->setDescription('Planifiez votre journée en toute simplicité. Choisissez un délai de collecte et de livraison qui vous convient.');
        $howWorks1->setLaundry($laundry);
        $manager->persist($howWorks1);

        $step3 = new Step();
        $step3->setTitle('Emballez un sac par service.');
        $step3->setIcon('svg3.svg');
        $step3->setRang(1);
        $step3->setHowWork($howWorks1);
        $howWorks1->addStep($step3);
        $manager->persist($step3);

        $step4 = new Step();
        $step4->setTitle('Pas besoin de compter ou de peser vos articles');
        $step4->setIcon('svg4.svg');
        $step4->setRang(2);
        $step4->setHowWork($howWorks1);
        $howWorks1->addStep($step4);
        $manager->persist($step4);

        $howWorks2 = new HowWorks();
        $howWorks2->setIndice('Souple');
        $howWorks2->setTitle('Planifiez votre collecte');
        $howWorks2->setImage('img10.png');
        $howWorks2->setRang(3);
        $howWorks2->setDescription('Planifiez votre journée en toute simplicité. Choisissez un délai de collecte et de livraison qui vous convient.');
        $howWorks2->setLaundry($laundry);
        $manager->persist($howWorks2);

        $step5 = new Step();
        $step5->setTitle('Mises à jour régulières des commandes');
        $step5->setIcon('svg5.svg');
        $step5->setRang(1);
        $step5->setHowWork($howWorks2);
        $howWorks2->addStep($step5);
        $manager->persist($step5);

        $step6 = new Step();
        $step6->setTitle('Suivi des conducteurs en temps réel');
        $step6->setIcon('svg6.svg');
        $step6->setRang(2);
        $step6->setHowWork($howWorks2);
        $howWorks2->addStep($step6);
        $manager->persist($step6);

        $howWorks3 = new HowWorks();
        $howWorks3->setIndice('Souple');
        $howWorks3->setTitle('Planifiez votre collecte');
        $howWorks3->setImage('img10.png');
        $howWorks3->setRang(4);
        $howWorks3->setDescription('Planifiez votre journée en toute simplicité. Choisissez un délai de collecte et de livraison qui vous convient.');
        $howWorks3->setLaundry($laundry);
        $manager->persist($howWorks3);

        $step7 = new Step();
        $step7->setTitle('Délai d\'exécution de 24 heures.');
        $step7->setIcon('svg7.svg');
        $step7->setRang(1);
        $step7->setHowWork($howWorks3);
        $howWorks3->addStep($step7);
        $manager->persist($step7);
        
        $step8 = new Step();
        $step8->setTitle('Suivi des commandes en temps réel');
        $step8->setIcon('svg5.svg');
        $step8->setRang(2);
        $step8->setHowWork($howWorks3);
        $howWorks3->addStep($step8);
        $manager->persist($step8);

        $step9 = new Step();
        $step9->setTitle('Facile à reprogrammer');
        $step9->setIcon('svg8.svg');
        $step9->setRang(3);
        $step9->setHowWork($howWorks3);
        $howWorks3->addStep($step9);
        $manager->persist($step9);

        $manager->flush();
    }
}
