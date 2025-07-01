<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;

class MessageEmbeddedForm extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Tapez votre réponse ici...',
                ],
            ]);

        if (!$builder->getData() || !$builder->getData()->getId()) {
            $builder->addEventListener(\Symfony\Component\Form\FormEvents::POST_SUBMIT, function($event) {
                $message = $event->getData();
                if ($message instanceof Message && !$message->getUsere()) {
                    $message->setUsere($this->security->getUser());
                    $message->setCreatedAt(new \DateTime());
                }
            });
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
