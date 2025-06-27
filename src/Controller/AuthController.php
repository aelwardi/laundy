<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegisterUserForm;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();
        $signup = $this->createForm(RegisterUserForm::class, $user);
        $signup->handleRequest($request);
        if($signup->isSubmitted() && $signup->isValid()) {
            $user = $signup->getData();
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $signup->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_auth');
        }

        $lastUsername = $authenticationUtils->getLastUsername();
        $loginError = $authenticationUtils->getLastAuthenticationError();

        return $this->render('auth/index.html.twig', [
            'signup' => $signup->createView(),
            'last_username' => $lastUsername,
            'login_error' => $loginError,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->redirectToRoute('app_auth');
    }
}
