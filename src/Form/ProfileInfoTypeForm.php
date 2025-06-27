<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileInfoTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = 'w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm';
        $labelClass = 'block text-sm text-gray-600 mb-1';

        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => $inputClass],
                'label_attr' => ['class' => $labelClass],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => $inputClass],
                'label_attr' => ['class' => $labelClass],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => ['class' => $inputClass . ' mb-4'],
                'label_attr' => ['class' => $labelClass],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => $inputClass . ' mb-4'],
                'label_attr' => ['class' => $labelClass],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
