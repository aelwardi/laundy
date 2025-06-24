<?php

namespace App\Controller;

use App\Repository\HowWorksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HowWorksController extends AbstractController
{
    #[Route('/howWork', name: 'app_how_works')]
    public function index(HowWorksRepository $howWorksRepository): Response
    {
        $howWorks = $howWorksRepository->findAll();
        return $this->render('how_works/index.html.twig', [
            'howWorks' => $howWorks,
        ]);
    }
}
