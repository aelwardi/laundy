<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RegisterUserForm;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $signup = $this->createForm(RegisterUserForm::class);
        $signup->handleRequest($request);
        if($signup->isSubmitted() && $signup->isValid()) {
            $user = $signup->getData();
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('auth/index.html.twig', [
            'signup' => $signup->createView(),
        ]);
    }
}
