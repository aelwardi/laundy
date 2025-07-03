<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Order;
use App\Form\CommentType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/order')]
#[IsGranted('ROLE_USER')]
class OrderHistoryController extends AbstractController
{
    #[Route('/history', name: 'app_order_history')]
    public function history(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        
        $orders = $orderRepository->findBy(
            ['usere' => $user],
            ['id' => 'DESC']
        );

        return $this->render('order_history/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/details/{id}', name: 'app_order_details')]
    public function details(
        Order $order, 
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response {
        if ($order->getUsere() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas accéder à cette commande.');
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($order->getStatus()->value !== 'completed') {
                $this->addFlash('error', 'Vous ne pouvez laisser un commentaire que sur une commande terminée.');
                return $this->redirectToRoute('app_order_details', ['id' => $order->getId()]);
            }

            $existingComment = $entityManager->getRepository(Comment::class)
                ->findOneBy(['ordere' => $order]);

            if ($existingComment) {
                $this->addFlash('error', 'Vous avez déjà laissé un commentaire pour cette commande.');
                return $this->redirectToRoute('app_order_details', ['id' => $order->getId()]);
            }

            $comment->setOrdere($order);
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès !');
            return $this->redirectToRoute('app_order_details', ['id' => $order->getId()]);
        }

        return $this->render('order_history/details.html.twig', [
            'order' => $order,
            'comment_form' => $form->createView(),
        ]);
    }
}
