<?php

namespace App\Controller\Admin;

use App\Entity\SubService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class SubServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubService::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Sous-Service')
            ->setEntityLabelInPlural('Sous-Services')
            ->setPageTitle('index', 'Gestion des Sous-Services')
            ->setPageTitle('new', 'Créer un Sous-Service')
            ->setPageTitle('edit', 'Modifier le Sous-Service')
            ->setPageTitle('detail', 'Détails du Sous-Service');
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
            NumberField::new('price', 'Prix (€)')
                ->setNumDecimals(2)
                ->setFormTypeOptions([
                    'attr' => [
                        'step' => '0.01',
                        'min' => '0',
                    ],
                ]),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            AssociationField::new('coservice', 'Catégorie parent'),
        ];
    }
}
