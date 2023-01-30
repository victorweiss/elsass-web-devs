<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body', CKEditorType::class)
            ->add('imageFile', VichImageType::class, [
                'required' => true
            ])
            ->add('isBookingAvailable')
            ->add('totalSeats', NumberType::class)
            ->add('startAt', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
                ])
            ->add('endAt', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
                ])
            ->add('adminNote', TextareaType::class, [
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Informations suplémentaires'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
