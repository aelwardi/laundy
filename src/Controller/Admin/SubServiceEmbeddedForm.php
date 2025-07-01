<?php

namespace App\Controller\Admin;

use App\Entity\SubService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubServiceEmbeddedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du sous-service',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix (€)',
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => '0',
                ],
                'html5' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubService::class,
        ]);
    }
}
