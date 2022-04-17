<?php

namespace App\Form;

use App\Entity\Training;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Description')
            ->add('catchphrase')
            ->add('Sections', CollectionType::class, array(
                'entry_type' => SectionType::class,
                'by_reference'=> false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ))
            ->add('valider', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
