<?php

namespace App\Controller\Admin;

use App\Entity\CoSevice;
use App\Entity\SubService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoSeviceEmbeddedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la catégorie',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('subServices', CollectionType::class, [
                'entry_type' => SubServiceEmbeddedForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Sous-services',
                'entry_options' => [
                    'label' => false,
                ],
                'attr' => [
                    'class' => 'subservices-collection',
                    'data-template' => 'admin/subservice_collection.html.twig',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CoSevice::class,
        ]);
    }
}
