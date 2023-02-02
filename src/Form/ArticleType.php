<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug', TextType::class, [
                'required' => false,
                'help' => 'Sera généré automatiquement, sinon slug généré par cet input'
            ])
            ->add('subtitle')
            ->add('metaDescription')
            ->add('body', CKEditorType::class)

            ->add('imageFile', VichImageType::class, [
                'required' => false
            ])
            ->add('marking', ChoiceType::class, [
                'choices' => [
                    'Brouillon' => 'Brouillon',
                    'Actif' => 'Actif',
                ]
            ])
            ->add('category')
            ->add('tags')
            ->add('author');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
