<?php

namespace App\Form;

use App\Entity\SupportTicket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SupportTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Sujet',
                'attr' => [
                    'placeholder' => 'Sujet ...',
                    'class' => 'w-full border rounded-lg px-3 py-2'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un sujet',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le sujet doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                        'maxMessage' => 'Le sujet ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('messageContent', TextareaType::class, [
                'label' => 'Message',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Écrivez votre message...',
                    'class' => 'w-full border rounded-lg px-3 py-2 resize-none',
                    'rows' => 5
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un message',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'bg-cyan-500 text-white px-5 py-2 rounded-lg hover:bg-cyan-600 transition'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportTicket::class,
        ]);
    }
}
