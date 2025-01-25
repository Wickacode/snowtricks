<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserUpdateDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, array(
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Identifiant'
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Email'
                )
            ))

            ->add('avatar', FileType::class, array(
                'data_class' => null,
                'mapped' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'avatar',
                    'placeholder' => 'Upload'
                    )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
