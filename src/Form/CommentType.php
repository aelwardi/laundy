<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', ChoiceType::class, [
                'choices' => [
                    '⭐ 1 étoile' => 1,
                    '⭐⭐ 2 étoiles' => 2,
                    '⭐⭐⭐ 3 étoiles' => 3,
                    '⭐⭐⭐⭐ 4 étoiles' => 4,
                    '⭐⭐⭐⭐⭐ 5 étoiles' => 5,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Votre note',
                'attr' => [
                    'class' => 'rating-choice'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une note.'
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 5,
                        'notInRangeMessage' => 'La note doit être comprise entre 1 et 5.'
                    ])
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Partagez votre expérience avec notre service...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez écrire un commentaire.'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 1000,
                        'minMessage' => 'Votre commentaire doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre commentaire ne peut pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Publier mon commentaire',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
