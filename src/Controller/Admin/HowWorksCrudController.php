<?php

namespace App\Controller\Admin;

use App\Entity\HowWorks;
use App\Entity\Step;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HowWorksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HowWorks::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('indice')
                ->setLabel('Indice')
                ->setHelp('Mot-clé ou badge (ex: "Souple", "Rapide", etc.)'),
            
            TextField::new('title')
                ->setLabel('Titre'),
            
            ImageField::new('image')
                ->setLabel('Image')
                ->setHelp("Image illustrative en 600x600px.")
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setUploadDir('public')
                ->setBasePath('/')
                ->setRequired(false),
            
            IntegerField::new('rang')
                ->setLabel('Ordre d\'affichage')
                ->setHelp('Numéro d\'ordre pour l\'affichage (1, 2, 3, etc.)'),
            
            TextareaField::new('description')
                ->setLabel('Description')
                ->setNumOfRows(4),
            
            AssociationField::new('laundry')
                ->setLabel('Laverie')
                ->setRequired(true),
        ];

        if (in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT])) {
            $fields[] = CollectionField::new('steps')
                ->setLabel('Étapes')
                ->setEntryType(StepEmbeddedForm::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex()
                ->setHelp('Ajoutez les étapes de ce processus. Elles seront affichées dans l\'ordre du rang.');
        }

        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Processus')
            ->setEntityLabelInPlural('Comment ça fonctionne')
            ->setPageTitle('index', 'Gestion des processus')
            ->setPageTitle('new', 'Créer un nouveau processus')
            ->setPageTitle('edit', 'Modifier le processus')
            ->setDefaultSort(['rang' => 'ASC'])
            ->setPaginatorPageSize(10);
    }
}
