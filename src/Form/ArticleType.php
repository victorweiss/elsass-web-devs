<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('author', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role', '%"ROLE_ADMIN"%')
                        ->orderBy('u.id', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
