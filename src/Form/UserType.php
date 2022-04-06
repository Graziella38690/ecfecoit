<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Apprenant' => 'ROLE_LAERNING',
                    'Instructeur' => 'ROLE_TEACHER',
                    'Instructeur en attente' => 'ROLE_TEACHERWAIT'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles' 
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