<?php

namespace App\Controller\Admin;

use App\Entity\Step;
use App\Entity\HowWorks;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class StepCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Step::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Accès interdit')
            ->setHelp('index', 'Les étapes ne peuvent être gérées que depuis la page "Comment ça fonctionne".');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::EDIT, Action::DELETE, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, Action::linkToCrud('Retour aux HowWorks', 'fas fa-arrow-left', HowWorks::class));
    }
}
