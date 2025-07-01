<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\SupportTicket;
use App\Form\SupportTicketType;
use App\Repository\SupportTicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class TicketController extends AbstractController
{
    #[Route('/tickets', name: 'app_ticket')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        SupportTicketRepository $supportTicketRepository
    ): Response {
        $supportTicket = new SupportTicket();
        $form = $this->createForm(SupportTicketType::class, $supportTicket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supportTicket->setUsere($this->getUser());
            $supportTicket->setCreatedAt(new \DateTime());

            $message = new Message();
            $message->setContent($form->get('messageContent')->getData());
            $message->setCreatedAt(new \DateTime());
            $message->setUsere($this->getUser());
            $message->setSupportTicket($supportTicket);

            $entityManager->persist($supportTicket);
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('success', 'Votre ticket a été créé avec succès.');
            
            return $this->redirectToRoute('app_ticket');
        }

        $userTickets = $supportTicketRepository->findBy(
            ['usere' => $this->getUser()],
            ['createdAt' => 'DESC']
        );

        return $this->render('ticket/index.html.twig', [
            'form' => $form,
            'tickets' => $userTickets,
        ]);
    }

    #[Route('/tickets/{id}', name: 'app_ticket_show', requirements: ['id' => '\d+'])]
    public function show(SupportTicket $supportTicket): Response
    {
        if ($supportTicket->getUsere() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('ticket/show.html.twig', [
            'ticket' => $supportTicket,
        ]);
    }

    #[Route('/tickets/{id}/reply', name: 'app_ticket_reply', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function reply(
        SupportTicket $supportTicket,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($supportTicket->getUsere() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('reply_ticket_' . $supportTicket->getId(), $request->get('_token'))) {
            $this->addFlash('error', 'Token de sécurité invalide.');
            return $this->redirectToRoute('app_ticket');
        }

        $content = trim($request->get('content'));
        if (empty($content)) {
            $this->addFlash('error', 'Le message ne peut pas être vide.');
            return $this->redirectToRoute('app_ticket');
        }

        $message = new Message();
        $message->setContent($content);
        $message->setCreatedAt(new \DateTime());
        $message->setUsere($this->getUser());
        $message->setSupportTicket($supportTicket);

        $entityManager->persist($message);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réponse a été ajoutée.');
        
        return $this->redirectToRoute('app_ticket');
    }
}
