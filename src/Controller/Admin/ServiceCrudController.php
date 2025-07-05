<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\CoSevice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Service')
            ->setEntityLabelInPlural('Services')
            ->setPageTitle('index', 'Gestion des Services')
            ->setPageTitle('new', 'Créer un Service')
            ->setPageTitle('edit', 'Modifier le Service')
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
            TextField::new('name', 'Nom du service'),
            TextareaField::new('description', 'Description'),
            AssociationField::new('laundry', 'Blanchisserie'),
            ImageField::new('image', 'Image')
                ->setBasePath('/')
                ->setUploadDir('/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            ImageField::new('icon', 'Icône')
                ->setBasePath('/')
                ->setUploadDir('/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            CollectionField::new('coSevices', 'Catégories')
                ->setEntryType(CoSeviceEmbeddedForm::class)
                ->allowAdd()
                ->allowDelete()
                ->showEntryLabel(false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->setTemplatePath('admin/coservice_collection.html.twig')
                ->hideOnIndex(),
            CollectionField::new('detailsServices', 'Détails du service')
                ->setEntryType(DetailsServiceEmbeddedForm::class)
                ->allowAdd()
                ->allowDelete()
                ->showEntryLabel(false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->setTemplatePath('admin/detailsservice_collection.html.twig')
                ->hideOnIndex(),
        ];
    }
}
