<?php

namespace App\Controller;

use App\Form\ProfileInfoTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
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
        return $this->render('profile/index.html.twig', [
            'infoForm' => $infoForm->createView(),
        ]);
    }
}
