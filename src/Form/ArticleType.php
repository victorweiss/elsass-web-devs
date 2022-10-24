<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Article;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('subtitle')
            ->add('metaDescription')
            ->add('body')
            // ->add('updatedAt')
            ->add('image')
            // ->add('countViews')
            ->add('marking', ChoiceType::class, [
                'choices' => [
                    'Brouillon' => 'Brouillon',
                    'Actif' => 'Actif',
                    'Inactif' => 'Inactif',
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
