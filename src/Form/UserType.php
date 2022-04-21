<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            


        ->add('is_verified', CheckboxType::class, [
            'label'    => ' activer le compte',
            'required' => false,
        ])


            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Apprenant' => 'ROLE_LAERNING',
                    'Instructeur' => 'ROLE_TEACHER',
                    'Administrateur' => 'ROLE_ADMIN',
                   
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
