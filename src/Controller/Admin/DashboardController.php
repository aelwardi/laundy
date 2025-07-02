<?php

namespace App\Controller\Admin;

use App\Entity\HowWorks;
use App\Entity\Section;
use App\Entity\Service;
use App\Entity\CoSevice;
use App\Entity\SubService;
use App\Entity\DetailsService;
use App\Entity\User;
use App\Entity\SupportTicket;
use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(SectionCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::section('Contenu');
        yield MenuItem::linkToCrud('À propos de nous', 'fas fa-list', Section::class);
        yield MenuItem::linkToCrud('Comment ça fonctionne', 'fas fa-cogs', HowWorks::class);
        
        yield MenuItem::section('Services');
        yield MenuItem::linkToCrud('Services', 'fas fa-concierge-bell', Service::class);
        yield MenuItem::linkToCrud('Catégories de Services', 'fas fa-tags', CoSevice::class);
        yield MenuItem::linkToCrud('Sous-Services', 'fas fa-list-ul', SubService::class);
        yield MenuItem::linkToCrud('Détails de Services', 'fas fa-info-circle', DetailsService::class);
        
        yield MenuItem::section('Support Client');
        yield MenuItem::linkToCrud('Tickets de Support', 'fas fa-ticket-alt', SupportTicket::class);
        yield MenuItem::linkToCrud('Messages', 'fas fa-comments', Message::class);
        
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    }
}
