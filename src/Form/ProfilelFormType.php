<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Role\Role;

class ProfilelFormType extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {  
        
        $builder
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'E-mail'
        ])
        ->add(
            'Pseudo',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Pseudo'
            ]);
           

}

   

   
   






   
        
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
