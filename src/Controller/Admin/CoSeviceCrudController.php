<?php

namespace App\Controller\Admin;

use App\Entity\CoSevice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class CoSeviceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CoSevice::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie de Service')
            ->setEntityLabelInPlural('Catégories de Services')
            ->setPageTitle('index', 'Gestion des Catégories de Services')
            ->setPageTitle('new', 'Créer une Catégorie')
            ->setPageTitle('edit', 'Modifier la Catégorie')
            ->setPageTitle('detail', 'Détails de la Catégorie');
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
            TextField::new('title', 'Titre'),
            AssociationField::new('service', 'Service parent'),
            CollectionField::new('subServices', 'Sous-services')
                ->setEntryType(SubServiceEmbeddedForm::class)
                ->allowAdd()
                ->allowDelete()
                ->showEntryLabel(false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->hideOnIndex(),
        ];
    }
}
