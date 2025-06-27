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
        $builder
            ->add('address', TextType::class, ['label' => 'Adresse complète'])
            ->add('details', TextType::class, ['label' => 'Détails'])
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'adresse',
                'choices' => [
                    'Accueil' => typeAddressEnum::Accueil,
                    'Bureau' => typeAddressEnum::Bureau,
                    'Hôtel' => typeAddressEnum::Hotel,
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
