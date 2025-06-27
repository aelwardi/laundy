<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilePasswordTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = 'w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 text-sm';

        $builder
            ->add('current_password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe actuel',
                    'class' => $inputClass,
                ],
                'mapped' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nouveau mot de passe',
                    'class' => $inputClass,
                ],
                'mapped' => false,
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Confirmer le nouveau mot de passe',
                    'class' => $inputClass,
                ],
                'mapped' => false,
            ])
        ;
    }
}
