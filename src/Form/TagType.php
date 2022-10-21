<?php

namespace App\Form;

use App\Entity\Tag;
use App\Form\CategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            //         ->add('category', CollectionType::class, [
            //             'entry_type' => ChoiceType::class,
            //             'mapped' => true,
            //             'allow_add' => true,
            //         ]);
            // }
            // ->add('category', CategoryType::class, []);
        ;
    }
    // ->add('category', ChoiceType::class, [
    //     'choices' => TagType::class,
    // ])
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
