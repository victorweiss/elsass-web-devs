<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => [
                    'placeholder' => 'Entrez votre adresse email'
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'attr' => [
                    'placeholder' => 'Entrez le sujet de votre demande'
                ],
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Entrez votre message'
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'action_name' => 'contact',
                'locale' => 'fr',
                'constraints' => new Recaptcha3(['message' => "Un problème est survenu avec votre Captcha. Essayez de renvoyer le formulaire ou contactez-nous sur LinkedIn en nous communicant le code d'erreur suivant: {{ errorCodes }}"]),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
