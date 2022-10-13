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

use Symfony\Component\Validator\Constraint as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre nom',
                ],
                'label' => 'Nom',
            ])
            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => [
                        'placeholder' => 'Entrez votre adresse email'
                    ],
                    'label' => 'Adresse email',
                ]
            )
            ->add('subject', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez le sujet de votre demande'
                ],
                'label' => 'Sujet',
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Entrez votre message'
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(['message' => 'There were problems with your captcha. Please try again or contact with support and provide following code(s): {{ errorCodes }}']),
                'action_name' => 'contact',
                // 'script_nonce_csp' => $nonceCSP,
                'locale' => 'fr',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
