<?php

namespace App\Form;

use App\Entity\Address;
use App\Enum\typeAddressEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileAddressTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = 'w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#189eff] text-sm';

        $builder
            ->add('address', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Adresse Complète, ex : 12 rue Périer, 75012 Paris, France",
                    'class' => $inputClass,
                ],
            ])
            ->add('details', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Ajoutez les détails de l'adresse (nom de l'appartement, numéro, étage...)",
                    'class' => $inputClass,
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Accueil' => typeAddressEnum::Accueil,
                    'Bureau' => typeAddressEnum::Bureau,
                    'Hôtel' => typeAddressEnum::Hotel,
                ],
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'peer sr-only', 'autocomplete' => 'off'];
                },
                'row_attr' => ['class' => 'flex gap-3'],
                'label_attr' => ['class' => 'flex-1'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
