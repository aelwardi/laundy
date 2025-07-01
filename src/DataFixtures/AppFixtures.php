<?php

namespace App\DataFixtures;

use App\Entity\Laundry;
use App\Entity\Section;
use App\Entity\HowWorks;
use App\Entity\Step;
use App\Entity\CoSevice;
use App\Entity\DetailsService;
use App\Entity\Wash;
use App\Entity\Pressing;
use App\Entity\Ameublement;
use App\Entity\SubService;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('elwardi@gmail.com');
        $user->setFirstName('Abderrazzak');
        $user->setLastName('Elwardi');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            password_hash('okokok', PASSWORD_BCRYPT)
        );
        $user->setPhone('1234567890');
        $manager->persist($user);


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
        $howWorks1->setImage('img11.png');
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
        $howWorks2->setImage('img12.png');
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
        $howWorks3->setImage('img13.png');
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

        $wash = new Wash();
        $wash->setName('Laver');
        $wash->setDescription('Pour le linge de tous les jours, les draps et les serviettes.');
        $wash->setImage('img14.png');
        $wash->setIcon('icon1.png');
        $wash->setLaundry($laundry);
        $manager->persist($wash);

        $detailsService = new DetailsService();
        $detailsService->setName('Vue d\'ensemble du service');
        $detailsService->setDescription('Vos articles sont lavés en machine à 30°C et séchés au sèche-linge. Le repassage n\'est pas inclus. 45°C peuvent être demandés sans frais supplémentaires.');
        $detailsService->setIcon('icon4.png');
        $detailsService->setService($wash);
        $manager->persist($detailsService);

        $detailsService1 = new DetailsService();
        $detailsService1->setName('Options du service');
        $detailsService1->setDescription('Linge non trié
        Nous laverons et sècheront votre linge au sèche-linge tel que vous l\'enverrez, toutes couleurs confondues.
        Linge trié
        Nous séparerons votre linge en deux lots, clair et foncé, et laverons chaque lot séparément afin de minimiser le risque de transfert de couleur.');
        $detailsService1->setIcon('icon5.png');
        $detailsService1->setService($wash);
        $manager->persist($detailsService1);

        $detailsService2 = new DetailsService();
        $detailsService2->setName('Convient pour');
        $detailsService2->setDescription('Linge de tous les jours qui peut être lavé en machine et séché au sèche-linge. Certains articles populaires généralement inclus sont les t-shirts, les pantalons, les draps et les sous-vêtements.');
        $detailsService2->setIcon('icon5.png');
        $detailsService2->setService($wash);
        $manager->persist($detailsService2);

        $detailsService3 = new DetailsService();
        $detailsService3->setName('Ne pas inclure');
        $detailsService3->setDescription('Linge non adapté au lavage en machine et/ou au sèche-linge
        Articles nettoyables à sec uniquement
        Tapis de bain
        Couettes et objets encombrants
        Tout type de chaussures
        Lits/articles pour animaux de compagnie');
        $detailsService3->setIcon('icon6.png');
        $detailsService3->setService($wash);
        $manager->persist($detailsService3);

        $detailsService4 = new DetailsService();
        $detailsService4->setName('Comment se préparer à la collecte');
        $detailsService4->setDescription('Si vous réservez plusieurs services, veuillez préparer tous les articles pour le service de lavage dans un sac séparé. Votre chauffeur Laundryheap étiquetera le sac auprès du service requis.');
        $detailsService4->setIcon('icon7.png');
        $detailsService4->setService($wash);
        $manager->persist($detailsService4);

        $detailsService5 = new DetailsService();
        $detailsService5->setName('Comment recevrez-vous les articles en retour');
        $detailsService5->setDescription('Nous vous retournerons votre linge propre, bien emballé, dans un sac.');
        $detailsService5->setIcon('icon9.png');
        $detailsService5->setService($wash);
        $manager->persist($detailsService5);

        $coService = new CoSevice();
        $coService->setTitle('Laver');
        $coService->setService($wash);
        $manager->persist($coService);

        $subService = new SubService();
        $subService->setName('Lavage non Trié');
        $subService->setPrice(4.15);
        $subService->setDescription('Linge clair et foncé lavé ensemble à 30°C. Vous pouvez demander 45°C.');
        $subService->setCoservice($coService);
        $manager->persist($subService);

        $subService1 = new SubService();
        $subService1->setName('Lavage Trié');
        $subService1->setPrice(4.15);
        $subService1->setDescription('Nous séparerons les articles pour vous et les laverons à 30°C. Commence avec deux charges. Vous pouvez demander 45°C à la place.');
        $subService1->setCoservice($coService);
        $manager->persist($subService1);

        $pressing = new Pressing();
        $pressing->setName('Pressing');
        $pressing->setDescription('Pour vêtements et tissus délicats.');
        $pressing->setImage('img15.png');
        $pressing->setIcon('icon2.png');
        $pressing->setLaundry($laundry);
        $manager->persist($pressing);

        $detailsService6 = new DetailsService();
        $detailsService6->setName('Vue d\'ensemble du service');
        $detailsService6->setDescription('Vos articles sont nettoyés à sec et repassés.');
        $detailsService6->setIcon('icon4.png');
        $detailsService6->setService($pressing);
        $manager->persist($detailsService6);

        $detailsService7 = new DetailsService();
        $detailsService7->setName('Convient pour');
        $detailsService7->setDescription('Tous les articles qui peuvent être nettoyés à sec et repassés. Certains des articles les plus populaires qui sont généralement inclus sont les costumes, les chemises, les robes et les manteaux.');
        $detailsService7->setIcon('icon5.png');
        $detailsService7->setService($pressing);
        $manager->persist($detailsService7);

        $detailsService8 = new DetailsService();
        $detailsService8->setName('Ne pas inclure');
        $detailsService8->setDescription('Articles qui ne conviennent pas au nettoyage à sec et/ou au repassage.');
        $detailsService8->setIcon('icon7.png');
        $detailsService8->setService($pressing);
        $manager->persist($detailsService8);

        $detailsService9 = new DetailsService();
        $detailsService9->setName('Comment se préparer à la collecte');
        $detailsService9->setDescription('Si vous réservez plusieurs services, veuillez préparer tous les articles pour le service de nettoyage à sec dans un sac séparé. Inutile de lister tous les articles, nous nous en occuperons.');
        $detailsService9->setIcon('icon7.png');
        $detailsService9->setService($pressing);
        $manager->persist($detailsService9);

        $detailsService10 = new DetailsService();
        $detailsService10->setName('Comment recevrez-vous les articles en retour');
        $detailsService10->setDescription('Nous vous retournerons vos articles propres sur des cintres. Certains articles peuvent être pliés sur demande, moyennant des frais supplémentaires.');
        $detailsService10->setIcon('icon8.png');
        $detailsService10->setService($pressing);
        $manager->persist($detailsService10);


        $coService1 = new CoSevice();
        $coService1->setTitle('Chemises');
        $coService1->setService($pressing);
        $manager->persist($coService1);

        $subService2 = new SubService();
        $subService2->setName('Chemise sur Cintre');
        $subService2->setPrice(4.20);
        $subService2->setCoservice($coService1);
        $manager->persist($subService2);

        $subService3 = new SubService();
        $subService3->setName('Chemise Pliée');
        $subService3->setPrice(4.90);
        $subService3->setCoservice($coService1);
        $manager->persist($subService3);

        $coService2 = new CoSevice();
        $coService2->setTitle('Chemisiers');
        $coService2->setService($pressing);
        $manager->persist($coService2);
       
        $subService2 = new SubService();
        $subService2->setName('Gilet');
        $subService2->setPrice(9);
        $subService2->setCoservice($coService2);
        $manager->persist($subService2);

        $subService3 = new SubService();
        $subService3->setName('Pull');
        $subService3->setPrice(9);
        $subService3->setCoservice($coService2);
        $manager->persist($subService3);

        $subService4 = new SubService();
        $subService4->setName('Polo sur Cintre');
        $subService4->setPrice(5.90);
        $subService4->setCoservice($coService2);
        $manager->persist($subService4);

        $subService5 = new SubService();
        $subService5->setName('Polo Pliée');
        $subService5->setPrice(7);
        $subService5->setCoservice($coService2);
        $manager->persist($subService5);

        $subService6 = new SubService();
        $subService6->setName('Chemisier');
        $subService6->setPrice(8);
        $subService6->setCoservice($coService2);
        $manager->persist($subService6);

        $coService3 = new CoSevice();
        $coService3->setTitle('Pantalons / Jupes');
        $coService3->setService($pressing);
        $manager->persist($coService3);

        $subService7 = new SubService();
        $subService7->setName('Short');
        $subService7->setPrice(8);
        $subService7->setCoservice($coService3);
        $manager->persist($subService7);

        $subService8 = new SubService();
        $subService8->setName('Jupe');
        $subService8->setPrice(9);
        $subService8->setCoservice($coService3);
        $manager->persist($subService8);

        $subService9 = new SubService();
        $subService9->setName('Pantalon');
        $subService9->setPrice(9);
        $subService9->setCoservice($coService3);
        $manager->persist($subService9);

        $coService4 = new CoSevice();
        $coService4->setTitle('Pantalons / Jupes');
        $coService4->setService($pressing);
        $manager->persist($coService4);

        $subService10 = new SubService();
        $subService10->setName('Costume (2 pièces)');
        $subService10->setPrice(19);
        $subService10->setCoservice($coService4);
        $manager->persist($subService10);

        $subService11 = new SubService();
        $subService11->setName('Costume (3 pièces)');
        $subService11->setPrice(25);
        $subService11->setCoservice($coService4);
        $manager->persist($subService11);

        $coService5 = new CoSevice();
        $coService5->setTitle('Robes');
        $coService5->setService($pressing);
        $manager->persist($coService5);

        $subService12 = new SubService();
        $subService12->setName('Robe');
        $subService12->setPrice(25);
        $subService12->setCoservice($coService5);
        $manager->persist($subService12);

        $subService13 = new SubService();
        $subService13->setName('Robe - Soirée');
        $subService13->setPrice(25);
        $subService13->setCoservice($coService5);
        $manager->persist($subService13);

        $subService14 = new SubService();
        $subService14->setName('Combinaison');
        $subService14->setPrice(19);
        $subService14->setCoservice($coService5);
        $manager->persist($subService14);

        $ameublement = new Ameublement();
        $ameublement->setName('Couettes & Ameublements');
        $ameublement->setDescription('Pour les articles plus volumineux qui nécessitent des soins supplémentaires.');
        $ameublement->setImage('img16.png');
        $ameublement->setIcon('icon3.png');
        $ameublement->setLaundry($laundry);
        $manager->persist($ameublement);

        $detailsService11 = new DetailsService();
        $detailsService11->setName('Vue d\'ensemble du service');
        $detailsService11->setDescription('Le processus de nettoyage varie en fonction des besoins de chaque article. Certains articles nécessiteront 72 heures pour être traités.');
        $detailsService11->setIcon('icon4.png');
        $detailsService11->setService($ameublement);
        $manager->persist($detailsService11);

        $detailsService12 = new DetailsService();
        $detailsService12->setName('Convient pour');
        $detailsService12->setDescription('Articles volumineux qui ne peuvent pas être nettoyés lors d\'un lavage standard et qui nécessitent un traitement particulier. Certains des articles les plus populaires qui sont généralement inclus sont les couettes, les oreillers et les couvertures.');
        $detailsService12->setIcon('icon5.png');
        $detailsService12->setService($ameublement);
        $manager->persist($detailsService12);

        $detailsService13 = new DetailsService();
        $detailsService13->setName('Ne pas inclure');
        $detailsService13->setDescription('Draps, housses de couette, taies d\'oreiller et serviettes. Vous pouvez sélectionner un service de lavage pour ces derniers.');
        $detailsService13->setIcon('icon7.png');
        $detailsService13->setService($ameublement);
        $manager->persist($detailsService13);

        $detailsService14 = new DetailsService();
        $detailsService14->setName('Comment se préparer à la collecte');
        $detailsService14->setDescription('Si vous réservez plusieurs services, veuillez préparer tous les articles pour le service Couettes & Articles encombrants dans un sac séparé. Inutile de lister tous les articles, nous nous en occuperons.');
        $detailsService14->setIcon('icon7.png');
        $detailsService14->setService($ameublement);
        $manager->persist($detailsService14);

        $detailsService15 = new DetailsService();
        $detailsService15->setName('Comment recevrez-vous les articles en retour');
        $detailsService15->setDescription('Nous vous retournerons vos articles propres dans un sac.');
        $detailsService15->setIcon('icon9.png');
        $detailsService15->setService($ameublement);
        $manager->persist($detailsService15);

        $coService6 = new CoSevice();
        $coService6->setTitle('Couettes plume');
        $coService6->setService($ameublement);
        $manager->persist($coService6);

        $subService15 = new SubService();
        $subService15->setName('Couette Plume - Simple');
        $subService15->setPrice(35.90);
        $subService15->setCoservice($coService6);
        $manager->persist($subService15);

        $subService16 = new SubService();
        $subService16->setName('Couette Plume - Double');
        $subService16->setPrice(38.90);
        $subService16->setCoservice($coService6);
        $manager->persist($subService16);

        $coService7 = new CoSevice();
        $coService7->setTitle('Couettes Synthétique');
        $coService7->setService($ameublement);
        $manager->persist($coService7);

        $subService17 = new SubService();
        $subService17->setName('Couette Synthétique - Simple');
        $subService17->setPrice(25);
        $subService17->setCoservice($coService7);
        $manager->persist($subService17);

        $subService18 = new SubService();
        $subService18->setName('Couette Synthétique - Double');
        $subService18->setPrice(28);
        $subService18->setCoservice($coService7);
        $manager->persist($subService18);

        $coService8 = new CoSevice();
        $coService8->setTitle('Couvertures & couvre-lits');
        $coService8->setService($ameublement);
        $manager->persist($coService8);

        $subService19 = new SubService();
        $subService19->setName('Couvre-lit - Seul - Lavable');
        $subService19->setPrice(21);
        $subService19->setCoservice($coService8);
        $manager->persist($subService19);

        $subService20 = new SubService();
        $subService20->setName('Couvre-lit - Double - Lavable');
        $subService20->setPrice(21);
        $subService20->setCoservice($coService8);
        $manager->persist($subService20);

        $subService21 = new SubService();
        $subService21->setName('Couverture - Simple - Lavable');
        $subService21->setPrice(21);
        $subService21->setCoservice($coService8);
        $manager->persist($subService21);

        $subService22 = new SubService();
        $subService22->setName('Couverture - Double - Lavable');
        $subService22->setPrice(21);
        $subService22->setCoservice($coService8);
        $manager->persist($subService22);

        $coService9 = new CoSevice();
        $coService9->setTitle('Oreillers');
        $coService9->setService($ameublement);
        $manager->persist($coService9);

        $subService23 = new SubService();
        $subService23->setName('Pillow - Feather');
        $subService23->setPrice(16);
        $subService23->setCoservice($coService9);
        $manager->persist($subService23);

        $subService24 = new SubService();
        $subService24->setName('Oreiller - Synthétique');
        $subService24->setPrice(14);
        $subService24->setCoservice($coService9);
        $manager->persist($subService24);

        $manager->flush();
    }
}
