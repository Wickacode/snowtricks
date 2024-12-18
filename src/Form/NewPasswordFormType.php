<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, array(
            'attr' => array(
                'class' => 'formInput',
                'placeholder' => 'Entrez votre mail'
            )
        ))
        ->add('newPlainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => [
                'autocomplete' => 'new-password',
                'class' => 'formInput',
                'placeholder' => 'Saisir votre nouveau mot de passe'
            
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Confirmer votre nouveau mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('newPasswordConfirm', PasswordType::class, array(
            'attr' => array(
                'class' => 'formInput',
                'placeholder' => 'Confirmer le nouveau mot de passe'
            )
        ))
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
