<?php

namespace App\Form;

use App\Entity\EventBooking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isPresenting', ChoiceType::class, [
                'label' => 'Souhaitez-vous présenter ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Si oui, que souhaitez-vous présenter ?'
                ],
                'required' => false,
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventBooking::class,
        ]);
    }
}
