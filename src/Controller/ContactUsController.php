<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactUsController extends AbstractController
{
    #[Route('/contactUs', name: 'app_contact_us')]
    public function index(): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_ticket');
        }

        return $this->render('contact_us/index.html.twig');
    }
}
