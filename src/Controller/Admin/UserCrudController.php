<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Symfony\Component\HttpFoundation\Response;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('index', 'Gestion des Utilisateurs')
            ->setPageTitle('detail', 'Détails de l\'Utilisateur')
            ->setDefaultSort(['firstName' => 'ASC'])
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT, Action::DELETE);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        
        if ($this->getUser()) {
            $queryBuilder
                ->andWhere('entity.id != :currentUserId')
                ->setParameter('currentUserId', $this->getUser()->getId());
        }
        
        return $queryBuilder;
    }

    public function edit(AdminContext $context): Response
    {
        throw $this->createAccessDeniedException('Modification des utilisateurs non autorisée via l\'admin.');
    }

    public function new(AdminContext $context): Response
    {
        throw $this->createAccessDeniedException('Création d\'utilisateurs non autorisée via l\'admin.');
    }

    public function delete(AdminContext $context): Response
    {
        throw $this->createAccessDeniedException('Suppression d\'utilisateurs non autorisée via l\'admin.');
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('firstName', 'Prénom')
                ->setColumns(6),
            TextField::new('lastName', 'Nom')
                ->setColumns(6),
            EmailField::new('email', 'Email')
                ->setColumns(8),
            TextField::new('phone', 'Téléphone')
                ->setColumns(4),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ])
                ->renderAsBadges([
                    'ROLE_USER' => 'success',
                    'ROLE_ADMIN' => 'danger'
                ])
                ->hideOnIndex(),
            AssociationField::new('laundry', 'Laverie associée')
                ->hideOnIndex(),
        ];

        if (Crud::PAGE_DETAIL === $pageName) {
            $fields[] = CollectionField::new('addresse', 'Adresses')
                ->setTemplatePath('bundles/EasyAdminBundle/crud/field/user_addresses.html.twig');
            $fields[] = CollectionField::new('orders', 'Commandes')  
                ->setTemplatePath('bundles/EasyAdminBundle/crud/field/user_orders.html.twig');
        }

        return $fields;
    }
}
