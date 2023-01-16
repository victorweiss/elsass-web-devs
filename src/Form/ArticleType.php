<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Article;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'help' => 'laissez vide, sera généré automatiquement'
            ])
            ->add('subtitle')
            ->add('metaDescription')
            ->add('body', CKEditorType::class)
// ICI POUR LIEN AVEC LE FOS_CKEDITOR.YAML

            ->add('imageFile', VichImageType::class, [
                'required' => false
            ])
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
