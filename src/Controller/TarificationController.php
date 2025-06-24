<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TarificationController extends AbstractController
{
    #[Route('/tarification', name: 'app_tarification')]
    public function index(): Response
    {
        return $this->render('tarification/index.html.twig', [
            'controller_name' => 'TarificationController',
        ]);
    }
}
