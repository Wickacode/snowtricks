<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Tricks;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TricksFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleTrick', TextType::class, array(
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Nom de la figure'
                )
            ))
            ->add('contentTrick', TextareaType::class, array(
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Description de la figure'
                )
            ))
            ->add('mainImg', FileType::class, array(
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Image principale'
                )
            ))
            ->add('mediaImages', FileType::class, array(
                'mapped' => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Images secondaires'
                )
            ))
            ->add('mediaVideo', UrlType::class, array(
                'mapped' => false,
                'attr' => array(
                    'class' => 'formInput',
                    'placeholder' => 'Vidéo'
                )
            ))
            ->add('categories', EntityType::class, array(
                'class' => Categories::class,
                'choice_label' => 'nameCat'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
