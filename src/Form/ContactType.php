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
                    'minLenght' => '2',
                    'maxLenght' => '50',
                    'placeholder' => 'Entrez votre nom',
                ],
                'label' => 'Nom',
            ])
            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => [
                        'minLenght' => '2',
                        'maxLenght' => '180',
                        'placeholder' => 'Entrez votre adresse email'
                    ],
                    'label' => 'Adresse email',
                    // 'constraints' => [
                    //     new Assert\NotBlank(),
                    //     new Assert\Email(),
                    //     new Assert\Lenght(['min' => '2', 'max' => 180])
                    // ]
                ]
            )
            ->add('subject', TextType::class, [
                'attr' => [
                    'minLenght' => '2',
                    'maxLenght' => '50',
                    'placeholder' => 'Entrez le sujet de votre demande'
                ],
                'label' => 'Sujet',
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Entrez votre message'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
