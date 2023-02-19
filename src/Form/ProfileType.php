<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('Pseudo',TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Pseudo'
        ])

        ->add('Firstname',TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Prenom'
        ])
        ->add('Lastname',TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Nom'
        ])

        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'E-mail'
        ])


            
            
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    
}
