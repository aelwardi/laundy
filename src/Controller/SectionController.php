<?php

namespace App\Controller;

use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SectionController extends AbstractController
{
    #[Route('/aboutUs', name: 'app_section')]
    public function index(SectionRepository $sectionRepository): Response
    {
        $sections = $sectionRepository->findAll();
        return $this->render('section/index.html.twig', [
            'sections' => $sections,
        ]);
    }
}
