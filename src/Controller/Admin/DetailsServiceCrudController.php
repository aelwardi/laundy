<?php

namespace App\Controller\Admin;

use App\Entity\DetailsService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class DetailsServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetailsService::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détail de Service')
            ->setEntityLabelInPlural('Détails de Services')
            ->setPageTitle('index', 'Gestion des Détails de Services')
            ->setPageTitle('new', 'Créer un Détail')
            ->setPageTitle('edit', 'Modifier le Détail')
            ->setPageTitle('detail', 'Détails du Service');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            TextField::new('icon', 'Icône'),
            AssociationField::new('service', 'Service parent'),
        ];
    }
}
