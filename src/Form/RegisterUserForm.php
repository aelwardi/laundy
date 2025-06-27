<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Laundry;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 transition mb-4'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 transition mb-4'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone',
                    'class' => 'w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 transition mb-4'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 transition mb-4'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => 'w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 transition mb-4'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
                , 'attr' => [
                    'class' => 'w-full bg-blue-500 text-white font-semibold rounded py-2 transition hover:bg-blue-400'
                ]
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
