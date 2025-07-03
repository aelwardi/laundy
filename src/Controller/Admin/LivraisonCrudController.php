<?php

namespace App\Controller\Admin;

use App\Entity\Livraison;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class LivraisonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livraison::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Livraison')
            ->setEntityLabelInPlural('Livraisons')
            ->setSearchFields(['fullName', 'fullAddress', 'ordere.id'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir détails')->setIcon('fas fa-eye');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            
            AssociationField::new('ordere', 'Commande')
                ->setColumns(6)
                ->setFormTypeOption('disabled', true)
                ->formatValue(function ($value) {
                    if ($value) {
                        return 'Commande #' . $value->getId() . ' (' . number_format($value->getPriceTotal(), 2) . ' €)';
                    }
                    return '';
                }),
            
            TextField::new('fullName', 'Nom complet')
                ->setColumns(6)
                ->setFormTypeOption('disabled', true),
            
            TextareaField::new('fullAddress', 'Adresse complète')
                ->setColumns(12)
                ->setNumOfRows(2)
                ->setFormTypeOption('disabled', true),
            
            DateTimeField::new('collectedAt', 'Date de collecte')
                ->setColumns(6)
                ->setFormat('dd/MM/yyyy HH:mm')
                ->setFormTypeOption('disabled', true),
            
            DateTimeField::new('livredAt', 'Date de livraison')
                ->setColumns(6)
                ->setFormat('dd/MM/yyyy HH:mm')
                ->setFormTypeOption('disabled', true),
            
            TextareaField::new('instructions', 'Instructions')
                ->setColumns(12)
                ->setNumOfRows(3)
                ->hideOnIndex()
                ->setFormTypeOption('disabled', true),
        ];
    }
}
