<?php

namespace App\Controller\Admin;

use App\Entity\Step;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class StepEmbeddedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'étape',
                'attr' => [
                    'placeholder' => 'Ex: Réservez en ligne'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le titre ne peut pas être vide']),
                ],
            ])
            ->add('icon', HiddenType::class, [
                'required' => false,
            ])
            ->add('iconFile', FileType::class, [
                'label' => 'Icône',
                'mapped' => false,
                'required' => false,
                'help' => 'Téléchargez un fichier d\'icône (SVG, PNG, JPG, etc.). Laissez vide pour conserver l\'icône actuelle.',
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/svg+xml',
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide (SVG, PNG, JPG, GIF, WebP)',
                        'maxSizeMessage' => 'Le fichier ne doit pas dépasser 2MB'
                    ])
                ],
                'attr' => [
                    'accept' => 'image/*'
                ]
            ])
            ->add('rang', IntegerType::class, [
                'label' => 'Ordre',
                'attr' => [
                    'min' => 1,
                    'placeholder' => '1'
                ],
                'help' => 'Numéro d\'ordre pour l\'affichage des étapes',
                'constraints' => [
                    new NotBlank(['message' => 'L\'ordre ne peut pas être vide']),
                    new Positive(['message' => 'L\'ordre doit être un nombre positif']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Step::class,
        ]);
    }
}
