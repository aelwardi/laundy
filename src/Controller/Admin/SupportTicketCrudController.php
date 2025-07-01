<?php

namespace App\Controller\Admin;

use App\Entity\SupportTicket;
use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SupportTicketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SupportTicket::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Ticket de Support')
            ->setEntityLabelInPlural('Tickets de Support')
            ->setPageTitle('index', 'Gestion des Tickets de Support')
            ->setPageTitle('detail', 'Détails du Ticket')
            ->setPageTitle('edit', 'Répondre au Ticket')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        $chatAction = Action::new('chat', 'Conversation', 'fas fa-comments')
            ->linkToCrudAction('chat')
            ->setCssClass('btn btn-primary');

        return $actions
            ->add(Crud::PAGE_INDEX, $chatAction)
            ->disable(Action::NEW, Action::DELETE, Action::EDIT);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        
        $queryBuilder->orderBy('entity.createdAt', 'DESC');
        
        return $queryBuilder;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'N° Ticket'),
            TextField::new('name', 'Sujet du ticket'),
            AssociationField::new('usere', 'Utilisateur'),
            DateTimeField::new('createdAt', 'Date de création')
                ->setFormat('dd/MM/yyyy HH:mm'),
        ];
    }

    public function chat(AdminContext $context, EntityManagerInterface $entityManager, Request $request): Response
    {
        $ticketId = $request->query->get('entityId');
        
        if (!$ticketId) {
            throw $this->createNotFoundException('Ticket non trouvé');
        }
        
        $ticket = $entityManager->getRepository(SupportTicket::class)->find($ticketId);
        
        if (!$ticket) {
            throw $this->createNotFoundException('Ticket non trouvé');
        }
        
        if ($request->isMethod('POST') && $request->request->get('message_content')) {
            $messageContent = $request->request->get('message_content');
            
            if (!empty(trim($messageContent))) {
                $message = new Message();
                $message->setContent($messageContent);
                $message->setSupportTicket($ticket);
                $message->setUsere($this->getUser());
                $message->setCreatedAt(new \DateTime());
                
                $entityManager->persist($message);
                $entityManager->flush();
                
                $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
                return $this->redirect($adminUrlGenerator
                    ->setController(self::class)
                    ->setAction('chat')
                    ->setEntityId($ticket->getId())
                    ->generateUrl()
                );
            }
        }
        
        $messages = $entityManager->getRepository(Message::class)
            ->findBy(['supportTicket' => $ticket], ['createdAt' => 'ASC']);
        
        return $this->render('admin/support_chat.html.twig', [
            'ticket' => $ticket,
            'messages' => $messages,
            'ea_context' => $context,
        ]);
    }
}
