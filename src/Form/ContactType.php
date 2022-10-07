<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Validator\Constraint as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minLenght' => '2',
                    'maxLenght' => '50',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add(
                'email',
                EmailType::class
                // , [
                //     'attr' => [
                //         'class' => 'form-control',
                //         'minLenght' => '2',
                //         'maxLenght' => '180',
                //     ],
                //     'label' => 'Adresse email',
                //     'label_attr' => [
                //         'class' => 'form-label mt-4'
                //     ],
                //     // 'constraints' => [
                //     //     new Assert\NotBlank(),
                //     //     new Assert\Email(),
                //     //     new Assert\Lenght(['min' => '2', 'max' => 180])
                //     // ]
                // ]
            )
            ->add('subject', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minLenght' => '2',
                    'maxLenght' => '50',
                ],
                'label' => 'Sujet',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['rows' => 6],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
