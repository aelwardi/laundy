<?php

namespace App\Controller;

use App\Form\ProfileInfoTypeForm;
use App\Form\ProfilePasswordTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response
    {
        $user = $this->getUser();
        $infoForm = $this->createForm(ProfileInfoTypeForm::class, $user, [
            'validation_groups' => ['Default'],
        ]);
        $infoForm->handleRequest($request);
        if ($infoForm->isSubmitted() && $infoForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Informations mises à jour');
            return $this->redirectToRoute('app_profile');
        }

        $passwordForm = $this->createForm(ProfilePasswordTypeForm::class);
        $passwordForm->handleRequest($request);
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            if (!$hasher->isPasswordValid($user, $passwordForm->get('current_password')->getData())) {
                $passwordForm->get('current_password')->addError(new \Symfony\Component\Form\FormError('Mot de passe actuel incorrect'));
            } elseif ($passwordForm->get('plainPassword')->getData() !== $passwordForm->get('confirmPassword')->getData()) {
                $passwordForm->get('confirmPassword')->addError(new \Symfony\Component\Form\FormError('Les mots de passe ne correspondent pas'));
            } else {
                $user->setPassword(
                    $hasher->hashPassword($user, $passwordForm->get('plainPassword')->getData())
                );
                $em->flush();
                $this->addFlash('success', 'Mot de passe changé');
                return $this->redirectToRoute('app_profile');
            }
        }

        return $this->render('profile/index.html.twig', [
            'infoForm' => $infoForm->createView(),
            'passwordForm' => $passwordForm->createView(),
        ]);
    }
}
